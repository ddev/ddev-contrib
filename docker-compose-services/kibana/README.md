# Kibana

This recipe adds Kibana container to a project.

This will allow you to visualize your Elasticsearch data and do anything from tracking query load to understanding the way requests flow through your apps.

**Note to Apple M1 and other arm64 users: At last check the [kibana 7.10.1 image](https://www.docker.elastic.co/r/kibana/kibana:7.10.1) referenced here was amd64-only, so your mileage may vary with this recipe. You may want to use one of the multiplatform images like kibana/kibana:7.13.3 at [the elastic.co docker repository](https://www.docker.elastic.co/r/kibana)**

## Requirements

Kibana requires a working instance of Elasticsearch running for it to connect to. This requires the [docker-compose recipe for elasticsearch in ddev-contrib](../elasticsearch).

## Configuration

If your Elasticsearch server is not available inside the kibana container at `http://ddev-<projectname>-elasticsearch:9200` (as it is when using the [ddev-contrib recipe](../elasticsearch), then you need to edit `docker-compose.kibana.yaml` and edit the following and edit the`ELASTICSEARCH_HOSTS` environment variable to the url your Elasticsearch server is available at within the kibana container.

Current Kibana version is 7.10.1, to change the version you need to edit the `image` parameter in `docker-compose.kibana.yaml`

## Installation

- Copy `docker-compose.kibana.yaml` to the `.ddev` folder of your project.
- Start (or restart) DDEV to have the service initialized: `ddev start`
- Access Kibana at `https://<DDEV_STENAME>.ddev.site:5602`.

**Contributed by [@alechko](https://github.com/alechko)**
