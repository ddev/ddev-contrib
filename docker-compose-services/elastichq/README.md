# ElasticHQ

This recipe adds an ElasticHQ container to a project.

This will allow you to have a graphical interface for browsing data in your Elasticsearch server.

## Requirements

Elastic HQ requires that there is a container within the project that has a working instance of Elasticsearch running for it to connect to. This is based on the [docker-compose recipe for elasticsearch in ddev-contrib](../elasticsearch).

## Configuration

If your Elasticsearch server is not available inside the elastichq container at `http://elasticsearch:9200` (as it is when using the [ddev-contrib recipe](../elasticsearch), then you need to edit `docker-compose.elastichq.yaml` and edit the following environment variable:

* Change `HQ_DEFAULT_URL` to the url your Elasticsearch server is available at within the elastichq container.

## Installation

* Copy `docker-compose.elastichq.yaml` to the `.ddev` folder of your project.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* Access your redis-commander UI at `http://<DDEV_STENAME>.ddev.site:5000` or via https at `https://<DDEV_SITENAME>.ddev.site:5443`.

**Contributed by [@Graloth](https://github.com/Graloth)**
