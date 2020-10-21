# Using Old PHP Versions (pre-php5.6)

It's not uncommon to need to be able to run a site that has been neglected for years or decades, often for upgrading, migrating, copying, or archiving purposes. But normally there are just too many errors and problems with these very old sites to get them to run with more recent PHP versions. And the oldest PHP version that ddev directly supports is PHP 5.6.

However, there are images of older PHP versions on hub.docker.com and we can use them as third-party services to get the behavior we need, which is usually just being able to *look* at a site.

This recipe was explicitly tested on Drupal 4.7 and 5.x, both from the 2008-2010 timeframe. 5.x installation succeeded with this configuration and PHP 5.3. Drupal 4.7 installation (very manual) succeeeded with PHP 5.2. Another approach which I used initially is to build the site or recover it on an Ubuntu 12.04 VM.

## Check out or download the repository and files into a project directory

For example, on a Drupal site you'll want the code and the user-uploaded files from sites/default/files.

If you're just kicking the tires, you can use a Drupal 4.7 version with `git clone -b 4.7.x https://git.drupal.org/project/drupal.git`.

## ddev config

* `ddev config --project-type=php --webserver-type=apache-fpm --mariadb-version=5.5` sets up your project

If your docroot is not the default, make sure to set it correctly in the .ddev/config.yaml.

Using Apache is more likely to be compatible with older projects, as is the use of older MariaDB. And we use project type 'php' so that ddev is not tempted to update settings files.

## Copy the files from [.ddev](.ddev) into your project's .ddev

For example `cp -r .ddev/* /path/to/your/repo/.ddev`

This includes:

* [apache/apache-site.conf](.ddev/apache/apache-site.conf), a generic apache configuration that does point to the external php container for php execution.
* [mysql/noutf8.cnf](.ddev/mysql/noutf8.cnf), turning off UTF8 in MariaDB. utf8mb4, required for most current sites, makes indexes too long on some older sites.
* [docker-compose.php.yaml](.ddev/docker-compose.php.yaml) adds the service itself.

## Start the project with `ddev start`

`ddev start`

## Get, load and optionally pre-condition your database dump

Get your database dump and load it into the 'db' database. Use `ddev import-db` or any other technique you prefer.

If older databases have `TYPE=MyISAM` in the table creation stanzas, that will need to be edited out. However, it may be possible to configure MariaDB in the .ddev/mysql directory to provide MyISAM.

## Configure the database settings for your project

ddev is taking no responsiblity for your settings files because you have `type: php`, so you'll need to configure your settings files. For example, on a Drupal 4.7 site, you'll need to add `$db_url = 'mysql://db:db@db/db';` to the sites/default/settings.php file. Don't forget that the *hostname* is 'db', not 'localhost' as often defaulted on many installers. (User/password/database are also 'db'.)

Now, if you're paranoid, do a `ddev restart` (probably unnecessary) and begin to debug the problems you've uncovered.

The site you've set up can probably be used as a migration source, can be archived, converted to html with a sitesucker, etc.

## Options

You may need another version of PHP. As noted in [docker-compose.php.yaml](.ddev/docker-compose.php.yaml), you can easily use 5.3, 5.4, or 5.5.

## Caveats

* OK, you know that these PHP versions are long out of support and this recipe is provided only to help you resurrect and port or hibernate an old site, not for presentation or production purposes.
* You definitely may have to do more than listed here to get your particular site going.
* I haven't experimented with getting PHP4 to work. Please provide a PR to this recipe if you get it to work.
