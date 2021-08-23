# Apache Solr Cloud Integration for DDEV-Local

Although ddev has [documented generic Solr support](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr) it only supports the single core mode and requires you to deal with configsets.

Running Solr in single core mode is not the recommended way anymore. The "Solr Cloud" mode is the preferred way and offers many additional features like Streaming Expressions and APIs that make management easier. 

To use Solr Cloud copy the `docker-compose.solr-cloud.yaml` and the `solr-cloud` directory (including `security.json`) to your project's `.ddev` folder.

## Drupal and Search API

For Drupal and Search API you just need to switch the configured Solr Connector to a Solr Cloud Connector.

Starting from Search API Solr module version 4.2.1 you don't need to deal with configsets manually any more. Just enable the `search_api_solr_admin` sub-module and configure the Search API Server to use the Solr Cloud Connector with Basic Auth. The username "solr" and the password "SolrRocks" are pre-configured in `.ddev/solr-cloud/security.json`. Now you
create or update your collection any time by clicking the "Upload Configset" button on the Search API server details page, or automate things using
```
ddev drush search-api-solr:upload-configset SERVER_ID
```

**Contributed by [@mkalkbrenner](https://github.com/mkalkbrenner)**
