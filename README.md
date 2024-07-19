# ddev-contrib: Contrib for DDEV

Contrib space for DDEV add-ons, services, tools, snippets, and approaches. **MOSTLY OBSOLETE!**

## THIS REPO IS MOSTLY OBSOLETE, Check the Add-On Registry!

**MOST OF THESE recipes have been made obsolete by DDEV add-ons. Please look for add-ons before using anything here. `ddev get --list --all`**

See [docs](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/) and `ddev get --list` for official add-ons, `ddev get --list --all` for all add-ons.

## config.yaml hook examples

* [Import a SQL dump if database is empty](hook-examples/import-db-if-empty/)

## docker-compose.*.yaml snippets to solve simple problems

Don't forget the [Official documentation](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/).

* [Mounting a directory into web container](docker-compose-snippets/mounting-directory/)
* [Setting an environment variable](docker-compose-snippets/environment-variable/docker-compose.env.yaml)
* [Communication between two DDEV projects](docker-compose-snippets/project-communication/)
* [Set default language (or other settings) in phpmyadmin](docker-compose-snippets/phpmyadmin-user-settings/)

## Custom command examples

DDEV's [custom commands](https://ddev.readthedocs.io/en/latest/users/extend/custom-commands/) are a great way to add team-level or project-level commands. They're simple scripts that can be run in any of the containers or on the host. Note that several examples are already shipped with DDEV, you'll find them in .ddev/commands/*/*.example, and then can be enabled by symlinking or copying.)

* [Dump and deploy SQL from/to remote servers](custom-commands/dump-and-deploy-db/)
* [Fetch Production DB from remote server](custom-commands/fetchproductiondb/)
* [Exclude DDEV directory from git: git-exclude](custom-commands/git-exclude)
* [Enable and view MySQL/MariaDB GENERAL_LOG](custom-commands/general-log/)
* [inotify-proxy to enable file watchers on NFS shares](custom-commands/inotify-proxy)
* [Executing Symfony console and phpunit commands without ssh](custom-commands/symfony/)
* [Build Drupal theme assets with Gulp](custom-commands/gulp) -- with minor modifications, this approach will work for other frameworks (WordPress, etc.) and other front-end build tools.
* [Run Laravel `tinker` or Drupal's `drush php` with a single command](custom-commands/tinker)
* [Stop all running projects except the current](custom-commands/stop-other)
* [Dynamically enable / disable a service](custom-commands/dynamic-service)
* [Automatically open browser and login to Drupal](custom-commands/drupal-login)
* [Run Silverstripe frameworks command directly](custom-commands/silverstripe)

## Additional services added via docker-compose.\<service\>.yaml

General information on how to do additional services and some additional examples are [in the docs](https://ddev.readthedocs.io/en/latest/users/extend/additional-services/).

* [Behat, Selenium, Drupal 8/9](docker-compose-services/drupal8-behat-selenium)
* [DrupalCI with Headless Chrome and Behat](docker-compose-services/drupalci-chromedriver). This example uses Drupal's DrupalCI approach, supports Behat, DrupalCI, etc.
* [Elastichq](docker-compose-services/elastichq)
* [Headless Chrome for Behat Testing](docker-compose-services/headless-chrome)
* [Kibana](docker-compose-services/kibana)
* [Meilisearch](docker-compose-services/meilisearch/)
* [MongoDB](docker-compose-services/mongodb/)
* [Old PHP Versions to run old sites](docker-compose-services/old_php)
* [Portainer Service for DDEV](docker-compose-services/portainer)
* [RabbitMQ](docker-compose-services/rabbitmq)
* [Solr 4 Integration (Drupal-focused)](docker-compose-services/solr-4)
* [Solr 5 Integration (Drupal-focused)](docker-compose-services/solr-5)
* [Solr 7 Integration (Drupal-focused)](docker-compose-services/solr-7)
* [Solr Integration (TYPO3-focused)](docker-compose-services/typo3-solr)
* [SQL Server (Microsoft)](docker-compose-services/sqlsrv)
* [Varnish](docker-compose-services/varnish)
* [XHGui](docker-compose-services/xhgui)

## .ddev/web-build/Dockerfile examples to customize web container

* [Laravel Queue-Worker](web-container-dockerfiles/laravel-queue-worker) (This is also a good example of adding an additional process to supervisord,)
* [Stripe CLI](web-container-dockerfiles/stripe-cli) (This is also a good example of adding any non-standard Debian repository.)
* [gRPC](web-container-dockerfiles/grpc) (This is also a good example of adding a pecl module that is not supported via apt-get.)

## Full recipes

* [Using DDEV with a corporate (or other) web proxy (obsolete - use `ddev get ddev/ddev-proxy-support`)](recipes/proxy)
* [enable TYPO3 cronjob on start or on demand (typo3 scheduler:run)](recipes/cronjob/)
* [Setting up Drupal 8 multisite, including Drush support](recipes/drupal8-multisite/)
* [Bludit CMS](recipes/bludit-cms)
* [Drupal 7 in a Subfolder of Main Site](recipes/drupal7-subfolder)
* [Flexitype CMS](recipes/flexitype-cms)
* [Laravel Horizon](recipes/laravel-horizon)
* [REDAXO CMS](recipes/redaxo-cms)
* [SSH Server](recipes/sshd): Adding a "real" sshd server in web container
  * Also see a more recent [third-party add-on](#third-party-add-ons) above
* [Puppeteer Headless Chrome support](recipes/puppeteer-headless-chrome-support/README.md)
* [PHPCS Git hook without PHP on the host machine](recipes/git-hooks/pre-commit-phpcs)
* [Install CiviCRM with DDEV](recipes/civicrm/)

## Third-party add-ons

* [SSH Server](https://github.com/hanoii/ddev-sshd)
