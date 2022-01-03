# Meilisearch

[Meilisearch](https://www.meilisearch.com/) is an open source search-engine and can be used in ddev to handle searchindexes for the Drupal search_api.
Using official meilisearch v0.20.0 container [meilisearch](https://hub.docker.com/r/getmeili/meilisearch).

## Installation

Copy [docker-compose.meilisearch.yaml](docker-compose.meilisearch.yaml) to your project's .ddev folder.

## Configuration

From within the container, the meilisearch container is reached at hostname: ddev-\<projectname\>-meilisearch, port: 7700, so the server URL might be `http://ddev-<projectname>-meilisearch:7700`.

## Connection

You can access the Meilisearch server directly from the host for debugging purposes by visiting `http://<projectname>.ddev.site:7700`.

You can use `ddev logs -s meilisearch` to investigate what the meilissearch daemon has been up to.

## Additional Resources

- https://www.drupal.org/project/search_api_meilisearch
- https://docs.meilisearch.com/learn/getting_started/quick_start.html

**Contributed by [@thilohille](https://github.com/thilohille)**
