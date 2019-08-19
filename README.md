# ddev-contrib
Contrib space for DDEV-Local services, tools, snippets, approaches

## config.yaml hook examples

* [Import a sql dump if database is empty](hook-examples/import-db-if-empty/README.md)

## docker-compose.*.yaml snippets to solve simple problems

Don't forget the [Official documentation](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/).

* [Mounting a directory into web container](docker-compose-snippets/mounting-directory/README.md)
* [Setting an environment variable](docker-compose-snippets/environment-variable/docker-compose.env.yaml)
* [Communication between two ddev projects](docker-compose-snippets/project-communication/README.md)

## Additional services added via docker-compose.\<service\>.yaml
* [MongoDB](docker-compose-services/mongodb/README.md)
* [Blackfire.io](docker-compose-services/blackfire/README.md)

## .ddev/web-build/Dockerfile examples to customize web container

## Full recipes

* [Using ddev with a corporate (or other) web proxy](recipes/proxy/README.md)
