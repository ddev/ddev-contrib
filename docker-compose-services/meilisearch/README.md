# Meilisearch

[Meilisearch](https://www.meilisearch.com/) is an open source search-engine. It can be used in ddev to handle search indexes for the Drupal search_api, or as a backend for Laravel Scout.

Using official meilisearch v0.27.2 container [meilisearch](https://hub.docker.com/r/getmeili/meilisearch).

## Installation

Copy [docker-compose.meilisearch.yaml](docker-compose.meilisearch.yaml) to your project's .ddev folder.

## Configuration

From within the container, the meilisearch container is reached at hostname: `ddev-<projectname>-meilisearch`, port: 7700, so the in-container server URL might be `http://ddev-<projectname>-meilisearch:7700`.

Setup a Master Key by setting the environment variable `MEILI_MASTER_KEY` to a 16 byte UTF-8 string.

## Connection

You can access the Meilisearch server directly from the host for debugging purposes by visiting `http://<projectname>.ddev.site:7700`.

You can use `ddev logs -s meilisearch` to investigate what the meilisearch daemon has been up to.

## Additional Resources

- [Drupal search_api_meilisearch module](https://www.drupal.org/project/search_api_meilisearch)
- [Meilisearch docs](https://docs.meilisearch.com/learn/getting_started/quick_start.html)
- [Laravel Scout](https://laravel.com/docs/9.x/scout)

**Contributed by [@thilohille](https://github.com/thilohille)**
