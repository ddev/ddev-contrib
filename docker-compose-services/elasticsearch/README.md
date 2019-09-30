## Elasticsearch

Using official Elasticsearch container [elasticsearch](https://hub.docker.com/_/elasticsearch).

### Installation

1. Copy [docker-compose-elasticsearch.yaml](docker-compose-elasticsearch.yaml) to your project

### Configuration

From within the container, the elasticsearch container is reached at hostname: elasticsearch, port: 9200, so the server URL might be `http://elasticsearch:9200`. 

### Connection

You can access the Elasticsearch server directly from the host for debugging purposes by visiting `http://<DDEV_STENAME>.ddev.site:9200`

### Memory Limit

This configuration limits memory usage to 512mb. This should be enough for most projects, but if your `elasticsearch` service stops with no obvious reason, increase your docker max memory or/and the service max memory.  
