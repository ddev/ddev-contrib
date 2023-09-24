# Install [CiviCRM](https://civicrm.org/) with DDEV

## What is CiviCRM

[CiviCRM](https://civicrm.org/) is an open source Customer Relationship Management solution for nonprofit and civic sector organizations. It is a highly customizable CRM, used by a diverse range of organizations around the world and translated into dozens of languages. 


## Configure DDEV

CiviCRM should work with the latest version of your favorite CMS, so create an instance of DDEV, for example [Drupal 10](https://ddev.readthedocs.io/en/latest/users/quickstart/#drupal).


## Install CiviCRM

See https://docs.civicrm.org/installation/en/latest/drupal/. Other CMS'es, such as Backdrop, Joomla, or WordPress are also supported.

For Drupal 10, download CiviCRM with this command. Study the guide above for details:

`ddev composer require civicrm/civicrm-{core,packages,drupal-8} --ignore-platform-req=ext-intl`

*ToDo*: Add command to add `ext-intl` PHP extension in DDEV.


## Import separate CiviCRM database, configure database and template settings

It was previously recommended to use two separate databases: One for the CMS, and one for CiviCRM. Currently, the recommendation is:

> It is also possible to install CiviCRM on a separate database. As a rule of thumb:
>
> - A shared database works well for small deployments (eg a few thousand records and a single administrator or developer).
> - Separate databases work well for large deployments (eg a million records and multiple administrators/developers).

https://docs.civicrm.org/installation/en/latest/general/requirements/#mysql-connection

If you need to restore a separate CiviCRM database in DDEV, first restore the Drupal installation files and database.

To set up DDEV, for example for a non-Composer Drupal 7 and CiviCRM with PHP 7.4, run this command:

`ddev config --project-type drupal7 --php-version 7.4 --docroot . --project-name civicrm`

Restore your Drupal 7 installation, and then import the CiviCRM database with this command:

`ddev import-db --database=cividb --file=cividb.sql`

**Note**: The extra database `cividb` will not be included if you run `ddev describe`.

### `civicrm.settings.php`

Comment out the server settings, and use these values in your `civicrm.settings.php` file, inserted right after global `$civicrm_root;` if you want to keep them in one place:

```
global $civicrm_root;

/* LOCAL DEVELOPMENT */
define( 'CIVICRM_UF_DSN'  , 'mysql://db:db@db:3306/cividb?new_link=true' );
define( 'CIVICRM_DSN'     , 'mysql://db:db@db:3306/cividb?new_link=true' );
define('CIVICRM_LOGGING_DSN', CIVICRM_DSN);
$civicrm_root = '/var/www/html/sites/all/modules/civicrm';
define( 'CIVICRM_TEMPLATE_COMPILEDIR', '/var/www/html/sites/default/files/civicrm/templates_c/' );
define( 'CIVICRM_UF_BASEURL'      , 'https://civicrm.ddev.site/' );
```
