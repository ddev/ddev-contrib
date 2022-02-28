# SQL Server (Microsoft)

Using SQL server from Microsoft.

## Installation

1. Copy `docker-compose.sqlsrv.yaml` to your project's `.ddev` directory.
2. Copy `Dockerfile` to your project's `.devv/web-build` directory.
3. Copy the full post start hook commands to your project's `config.yaml` or add them to `config.sqlsrv.yaml`.
4. *(optional)* For Drupal 9+ projects: copy `install-drupal-regex-function.sh` to your project's `.ddev` directory.

## Connection

Connect to `sqlsrv` host/db server from within the web container with:

```
Host: `ddev-projectname-sqlsrv`
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
   - exec: echo export PATH="$PATH:/opt/mssql-tools/bin" >> ~/.bashrc
   - exec: source ~/.bashrc
```

The minimum required PHP version the these extensions is PHP 7.3. For more information about these extension, see: [MS SQL driver for PHP](https://github.com/microsoft/msphpsql).


## Drupal Notice

Drupal CMS needs the a database function installed that is mimicking the Regex function as Drupal requires. As a one-time setup for Drupal, install the database function by running the following command from your project's directory:

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

* See [.ddev/config.yaml Options](https://ddev.readthedocs.io/en/stable/users/extend/config_yaml/) for additional notes.

## TODO

Future enhancements (PR's welcome here) include:

* Provide custom commands.

## Links with useful information

* [SQL Server docker hub](https://hub.docker.com/_/microsoft-mssql-server)
* [Installing the ODBC driver for SQL Server](https://docs.microsoft.com/en-us/sql/connect/odbc/linux-mac/installing-the-microsoft-odbc-driver-for-sql-server)
* [Installing the ODBC driver for SQL Server Tutorial](https://docs.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac)
* [Installation tutorial for MS drivers for PHP](https://docs.microsoft.com/en-us/sql/connect/php/installation-tutorial-linux-mac)
* [The SQLCMD utility](https://docs.microsoft.com/en-us/sql/tools/sqlcmd-utility)
* [The SQL Server on Linux](https://docs.microsoft.com/en-us/sql/linux/sql-server-linux-overview)
* [The password policy](https://docs.microsoft.com/en-us/sql/relational-databases/security/password-policy)
* [The SQL Server environment variables](https://docs.microsoft.com/en-us/sql/linux/sql-server-linux-configure-environment-variables)
* [Beakerboy's Drupal Regex database function](https://github.com/Beakerboy/drupal-sqlsrv-regex)
* [Drupal's module for the SQL Server](https://www.drupal.org/project/sqlsrv)
* [Github MS drivers for PHP](https://github.com/microsoft/msphpsql)
