# SQL Server (Microsoft)

Using SQL server from Microsoft.

## Installation

1. Copy `docker-compose.sqlsrv.yaml` to your project's `.ddev` directory.
2. Copy the full post start hook commands to your project's `config.yaml`.
3. *(optional)* For Drupal 9+ projects: copy `install-drupal-regex-function.sh` to your project's `.ddev` directory.

## Connection

Connect to `sqlsrv` host/db server from within the web container with:

```
Host: sqlsrv
User: sa
Password: password!
Database: master
```

Connect to `sqlsrv` host/db server from project directory:

```bash
ddev exec -s sqlsrv "/opt/mssql-tools/bin/sqlcmd -P password! -S localhost -U sa -d master"
```

For external access, use the port used in your `docker-compose.sqlsrv.yaml` and `127.0.0.1` as host.

When using multiple databases in your project with SQL Server support, remember to update your `docker-compose.sqlsrv.yaml` to use different ports:

```yaml
    ports:
      - <EXTERNAL_PORT>:1433
```

## Installing the PHP extensions

The PHP extensions for SQL Server CANNOT be installed by adding them to the `webimage_extra_packages` setting. The problem is that they are not available as a Debian or any other distribution package. The 2 extensions (`sqlsrv` and `pdo_sqlsrv`) need to be compiled and this needs to be done after PHP is installed on the webimage. The following commands need to be copied to the end of the main `config.yaml` file:

```yaml
hooks:
  post-start:
   - exec: "curl -s https://packages.microsoft.com/keys/microsoft.asc | sudo apt-key add -"

   # For the next line: change the Debian version number to the one that DDEV is
   # using. For DDEV v1.17.7 is it Debian version 10. Run the following command
   # to get the information: "ddev exec lsb_release -a". You shall probably need
   # to remove the post startup hooks to make the webserver boot in order to run
   # the command.
   - exec: sudo bash -c 'curl -s https://packages.microsoft.com/config/debian/10/prod.list > /etc/apt/sources.list.d/mssql-release.list'

   - exec: sudo apt-get -y update

   # When you have warnings or errors with multiarch, then please uncomment the
   # following lines.
   #- exec: wget http://archive.ubuntu.com/ubuntu/pool/main/g/glibc/multiarch-support_2.27-3ubuntu1.4_amd64.deb
   #- exec: sudo apt-get install ./multiarch-support_2.27-3ubuntu1.4_amd64.deb

   - exec: sudo apt-get -y install dialog apt-utils
   - exec: sudo ACCEPT_EULA=Y apt-get -y install msodbcsql17 mssql-tools
   - exec: echo 'export PATH="$PATH:/opt/mssql-tools/bin" >> ~/.bashrc'
   - exec: source ~/.bashrc
   - exec: sudo apt-get -y install unixodbc-dev
   - exec: sudo apt-get -y install gcc g++ make autoconf libc-dev pkg-config
   - exec: sudo apt-get -y install php-pear php-dev
   - exec: sudo pecl channel-update pecl.php.net
   - exec: sudo pecl install sqlsrv
   - exec: sudo pecl install pdo_sqlsrv

   # For the next 3 lines: change the PHP version number to the one set in
   # the variable: "php_version". The currently used PHP version is "8.0".
   - exec: "echo 'extension=sqlsrv.so' | sudo tee /etc/php/8.0/mods-available/sqlsrv.ini"
   - exec: "echo 'extension=pdo_sqlsrv.so' | sudo tee /etc/php/8.0/mods-available/pdo_sqlsrv.ini"
   - exec: sudo phpenmod -v 8.0 sqlsrv pdo_sqlsrv

   # When you get warnings or errors that there is something wrong with
   # uploadgrogress, then please uncomment the following lines.
   #- exec: sudo pecl install uploadprogress
   #- exec: "echo 'extension=uploadprogress.so' | sudo tee /etc/php/8.0/mods-available/uploadprogress.ini"
   #- exec: sudo phpenmod -v 8.0 uploadprogress

   # For the next line: change the word "nginx" to "apache2" when the variable
   # "webserver_type" is set to "apache-fpm".
   - exec: killall -USR2 nginx php-fpm

   # Test that the installation of the PHP extensions for the SQL Server were
   # successful.
   - exec: "echo 'When the installation was succesful, the following strings: \"pdo_sqlsrv\" and \"sqlsrv\" should appear. Each on its own line.'"
   - exec: "php -m | grep 'sqlsrv'"
```

The minimum required PHP version the these extensions is PHP 7.3. For more information about these extension, see: [MS SQL driver for PHP](https://github.com/microsoft/msphpsql).


## Drupal Notice

Drupal CMS needs the a database function installed that is mimicking the Regex function as Drupal requires. To install such a database function run the following command from your project's directory:

```bash
./install-drupal-regex-function.sh -u <username> -p <password> -d <database>
```

This script also changes the setting for the following database variables:
* `show advanced options` will be set to 1
* `clr strict security` will be set to 0
* `clr enable` will be set to 1

Drupal also the module `sqlsrv` to be installed as it is providing the database driver for SQL Server. The module can be installed with composer with the following command:

```bash
$ php composer require drupal/sqlsrv
```

## Disabling MySQL & MariaSQL

* If your project only uses a SQL Server database, you can disable the MySql & MariaDb services.
* Run the following command from your project root.

```bash
ddev config --omit-containers db
```

* Alternatively, you can update your project's `.ddev/config.yaml` directly by updating the following line:

```yaml
omit_containers: [db]
```

* See [.ddev/config.yaml Options](<https://ddev.readthedocs.io/en/stable/users/extend/config_yaml/>) for additional notes.

## TODO

Future enhancements (PR's welcome here) include:

* Provide custom commands.

## Links with useful information

* [SQL Server docker hub](https://hub.docker.com/_/microsoft-mssql-server)
* [Installing the ODBC driver for SQL Server](https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server?view=sql-server-ver15)
* [Installing the ODBC driver for SQL Server Tutorial](https://docs.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac?view=sql-server-ver15)
* [The SQLCMD utility](https://docs.microsoft.com/en-us/sql/tools/sqlcmd-utility?view=sql-server-ver15)
* [The SQL Server on Linux](https://docs.microsoft.com/en-us/sql/linux/sql-server-linux-overview?view=sql-server-ver15)
* [The password policy](https://docs.microsoft.com/en-us/sql/relational-databases/security/password-policy?view=sql-server-ver15)
* [The SQL Server environment variables](https://docs.microsoft.com/en-us/sql/linux/sql-server-linux-configure-environment-variables?view=sql-server-ver15)
* [Beakerboy's Drupal Regex database function](https://github.com/Beakerboy/drupal-sqlsrv-regex)
* [Drupal's module for the SQL Server](https://www.drupal.org/project/sqlsrv)
