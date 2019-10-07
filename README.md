# ddev-contrib
Contrib space for DDEV-Local services, tools, snippets, approaches

## config.yaml hook examples

* [Import a sql dump if database is empty](hook-examples/import-db-if-empty/README.md)

## docker-compose.*.yaml snippets to solve simple problems

Don't forget the [Official documentation](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/).

* [Mounting a directory into web container](docker-compose-snippets/mounting-directory/README.md)
* [Setting an environment variable](docker-compose-snippets/environment-variable/docker-compose.env.yaml)
* [Communication between two ddev projects](docker-compose-snippets/project-communication/README.md)

## Custom command examples

Ddev's [custom commands](https://ddev.readthedocs.io/en/latest/users/extend/custom-commands/) are a great way to add team-level or project-level commands. They're simple scripts that can be run in any of the containers or on the host. Note that several examples are already shipped with ddev, you'll find them in .ddev/commands/*/*.example, and then can be enabled by symlinking or copying.)

## Additional services added via docker-compose.\<service\>.yaml

General information on how to do additional services and some additional examples are [in the docs](https://ddev.readthedocs.io/en/latest/users/extend/additional-services/).

* [MongoDB](docker-compose-services/mongodb/)
* [Blackfire.io](docker-compose-services/blackfire/)
* [PostreSQL](docker-compose-services/postgres/)
* [Elasticsearch](docker-compose-services/elasticsearch)
* [Oracle MySQL](docker-compose-services/mysql)
* [Old PHP Versions to run old sites](docker-compose-services/old_php)

## .ddev/web-build/Dockerfile examples to customize web container

## Full recipes

* [Using ddev with a corporate (or other) web proxy](recipes/proxy/README.md)
* [enable cronjob on start or on demand (typo3 scheduler:run)](recipes/cronjob/README.md)
* [REDAXO CMS](recipes/redaxo-cms)
