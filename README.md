# ddev-contrib: Contrib for DDEV-Local

Contrib space for DDEV-Local services, tools, snippets, approaches.

## config.yaml hook examples

* [Import a sql dump if database is empty](hook-examples/import-db-if-empty/)

## docker-compose.*.yaml snippets to solve simple problems

Don't forget the [Official documentation](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/).

* [Mounting a directory into web container](docker-compose-snippets/mounting-directory/)
* [Setting an environment variable](docker-compose-snippets/environment-variable/docker-compose.env.yaml)
* [Communication between two ddev projects](docker-compose-snippets/project-communication/)

## Custom command examples

Ddev's [custom commands](https://ddev.readthedocs.io/en/latest/users/extend/custom-commands/) are a great way to add team-level or project-level commands. They're simple scripts that can be run in any of the containers or on the host. Note that several examples are already shipped with ddev, you'll find them in .ddev/commands/*/*.example, and then can be enabled by symlinking or copying.)

* [Dump and deploy SQL from/to remote servers](custom-commands/dump-and-deploy-db/)
* [Fetch Production DB from remote server](custom-commands/fetchproductiondb/)

## Additional services added via docker-compose.\<service\>.yaml

General information on how to do additional services and some additional examples are [in the docs](https://ddev.readthedocs.io/en/latest/users/extend/additional-services/).

* [MongoDB](docker-compose-services/mongodb/)
* [Blackfire.io](docker-compose-services/blackfire/)
* [PostgreSQL](docker-compose-services/postgres/)
* [Elasticsearch](docker-compose-services/elasticsearch)
* [Elastichq](docker-compose-services/elastichq)
* [Headless Chrome for Behat Testing](docker-compose-services/headless-chrome)
* [Old PHP Versions to run old sites](docker-compose-services/old_php)
* [RabbitMQ](docker-compose-services/rabbitmq)
* [redis](docker-compose-services/redis)
* [redis-commander](docker-compose-services/redis-commander)
* [TYPO3 Solr Integration](docker-compose-services/typo3-solr)

## .ddev/web-build/Dockerfile examples to customize web container

## Full recipes

* [Using ddev with a corporate (or other) web proxy](recipes/proxy)
* [enable TYPO3 cronjob on start or on demand (typo3 scheduler:run)](recipes/cronjob/)
* [Setting up Drupal 8 multisite, including Drush support](recipes/drupal8-multisite/)
* [Bludit CMS](recipes/bludit-cms)
* [Flexitype CMS](recipes/flexitype-cms)
* [Laravel PHP Framework](recipes/laravel)
* [REDAXO CMS](recipes/redaxo-cms)
