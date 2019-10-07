For the vast majority of use cases where MySQL is needed in a project, MariaDB is the best choice. MariaDB is faster and more feature-packed in many scenarios. However, sometimes a project really demands plain old MySQL.
This page documents how to create a separate MySQL container to use with ddev. It does not
replace the MariaDB or PHPMyAdmin containers. It also demonstrates how to connect Drupal to that container and database.

## ddev setup
1. Add [docker-compose.mysql.yaml](docker-compose.mysql.yaml) to your  project's `.ddev` directory.
2. Start or restart your project with `ddev start` or `ddev restart`.
3. You should see your container start up. You could look for it with `docker ps -a | grep mysql`. The container will be named ddev-[your project name]-mysql.

NB: We use MySQL 5.7, but it should be possible to use a different version. Check out the [MySQL Images on Docker Hub](https://hub.docker.com/_/mysql) for more options. Then change the image key in docker-compose.mysql.yaml. (A short attempt at 8.0.x was *not* successful).

## Connecting
If your container was successfully started, you should be able to access it from within the ddev webserver container.
1. Execute `ddev ssh` to ssh into your main ddev container.
2. Execute  something like `mysql -u root -p -h mysql --database=mysql` to connect.

## Drupal setup
1. After connecting create a database, where you want Drupal to live.
Something like `CREATE DATABASE db`.
2. Create a user with something like `CREATE USER 'db'@'localhost' IDENTIFIED BY 'db';`
3. Grant permissions on that database `GRANT ALL PRIVILEGES ON db.* TO 'db'@'%' IDENTIFIED BY "db";`
4. Configure your site settings as usual. Edit `sites/default/settings.ddev.php` and create a connection that has values like:
   ```
    $databases['default']['default'] = array(
      'database' => "db",
      'username' => "db",
      'password' => "db",
      'host' => "mysql",
      'driver' => "mysql",
      'port' => "3306",
      'prefix' => "",
    );
    ```
5. You'll likely want to use the "php" project type, rather than the "drupal7" or "drupal8" project type. This will prevent ddev from trying to adjust your database settings. (This is true for all CMSs using this setup.) `dev config --project-type=php` (or edit .ddev/config.yaml and set `type: php`)
6. Navigate to your site like normal and install.

## Caveats
1. ddev commands that are oriented to mariadb like ddev import-db, ddev export-db, and ddev snapshot won't work with this setup.

