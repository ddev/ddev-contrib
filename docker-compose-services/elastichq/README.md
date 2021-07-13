# ElasticHQ

This recipe adds an ElasticHQ container to a project.

This will allow you to have a graphical interface for browsing data in your Elasticsearch server.

**Note to Apple M1 and other arm64 users: At last check the [elasticsearch-hq image](https://hub.docker.com/r/elastichq/elasticsearch-hq) was amd64-only, so your mileage may vary with this recipe.**

## Requirements

Elastic HQ requires a working instance of Elasticsearch running for it to connect to. This is based on the [docker-compose recipe for elasticsearch in ddev-contrib](../elasticsearch).

## Configuration

If your Elasticsearch server is not available inside the elastichq container at `http://ddev-<projectname>-elasticsearch:9200` (as it is when using the [ddev-contrib recipe](../elasticsearch), then you need to edit `docker-compose.elastichq.yaml` and edit the following environment variable:

* Change `HQ_DEFAULT_URL` to the url where your Elasticsearch server is available from inside the elastichq container.

## Installation

* Copy `docker-compose.elastichq.yaml` to the `.ddev` folder of your project.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* Access your ElasticHQ UI at `http://<DDEV_STENAME>.ddev.site:5000` or via https at `https://<DDEV_SITENAME>.ddev.site:5443`.

**Contributed by [@Graloth](https://github.com/Graloth)**
