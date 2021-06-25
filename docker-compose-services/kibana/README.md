# Kibana

This recipe adds Kibana container to a project.

This will allow you to visualize your Elasticsearch data and do anything from tracking query load to understanding the way requests flow through your apps.

## Requirements

Kibana requires a working instance of Elasticsearch running for it to connect to. This is based on the [docker-compose recipe for elasticsearch in ddev-contrib](../elasticsearch).

## Configuration

If your Elasticsearch server is not available inside the elastichq container at `http://elasticsearch:9200` (as it is when using the [ddev-contrib recipe](../elasticsearch), then you need to edit `docker-compose.kibana.yaml` and edit the following environment variable:

- Change `ELASTICSEARCH_HOSTS` to the url your Elasticsearch server is available at within the elastichq container.

Current Kibana version is 7.10.1, to change the version you need to edit the `image` parameter in `docker-compose.kibana.yaml`

## Installation

- Copy `docker-compose.kibana.yaml` to the `.ddev` folder of your project.
- Start (or restart) DDEV to have the service initialized: `ddev start`
- Access Kibana at `http://<DDEV_STENAME>.ddev.site:5601`.

**Contributed by [@alechko](https://github.com/alechko)**
