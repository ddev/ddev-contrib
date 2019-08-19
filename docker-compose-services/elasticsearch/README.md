## Elasticsearch

Using official Elasticsearch container [elasticsearch](https://hub.docker.com/_/elasticsearch).

### Installation

1. Copy `docker-compose-elasticsearch.yaml` to your project

### Connection

Host: `http://<DDEV_STENAME>.ddev.site:9200`

### Memory Limit

This configuration limits memory usage to 512mb. This should be enough for most projects, but if your `elasticsearch` service stops with no obvious reason, increase your docker max memory or/and the service max memory.  
