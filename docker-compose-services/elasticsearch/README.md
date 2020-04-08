# Elasticsearch

Using official Elasticsearch container [elasticsearch](https://hub.docker.com/_/elasticsearch).

## Installation

Copy [docker-compose.elasticsearch.yaml](docker-compose.elasticsearch.yaml) to your project's .ddev folder.

## Configuration

From within the container, the elasticsearch container is reached at hostname: elasticsearch, port: 9200, so the server URL might be `http://elasticsearch:9200`. You can also use the non-SSL, and SSL urls to access it: `http://<DDEV_SITENAME>.ddev.site:9200`, and `https://<DDEV_SITENAME>.ddev.site:9201`

## Connection

You can access the Elasticsearch server directly from the host for debugging purposes by visiting `http://<DDEV_SITENAME>.ddev.site:9200`. If you have SSL enabled, which is recommended, you can access Elasticsearch via `https://<DDEV_SITENAME>.ddev.site:9201`

## Memory Limit

This configuration limits memory usage to 512mb. This should be enough for most projects, but if your `elasticsearch` service stops with no obvious reason, increase your docker max memory or/and the service max memory.

You can use `ddev logs -s elasticsearch` to investigate what the elasticsearch daemon has been up to, or if you have a RAM-related crash.

## Additional Resources

* There are two related answers to the [Stack Overflow question](https://stackoverflow.com/questions/54575785/how-can-i-use-an-elasticsearch-add-on-container-service-with-ddev) on ddev and Elasticsearch.
* @juampynr's Lullabot [article on Drupal 8 and Elasticsearch](https://www.lullabot.com/articles/indexing-content-from-drupal-8-to-elasticsearch) is helpful for Drupal users.
