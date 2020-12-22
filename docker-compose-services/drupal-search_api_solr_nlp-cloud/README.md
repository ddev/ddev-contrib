# Search API Solr specific Apache Solr Cloud Integration for DDEV-Local

Although ddev has [documented generic Solr support](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr) it is as simple as possible, and supports only a single core named "dev".

Search API Solr NLP provides a ready to use jump-start config-sets for Solr ion stand-alone and in Cloud mode.

1. Add the search_api_solr_nlp module to your project: `ddev composer require drupal/search_api_solr_nlp`
2. Copy [docker-compose.drupal-search_api_solr_nlp-cloud.yaml](docker-compose.drupal-search_api_solr_nlp-cloud.yaml) to your project's .ddev folder.
3. `ddev restart` will bring up the new solr container.
4. Enable the Search API Solr module: `ddev drush en search_api_solr_nlp`
5. Import the config `web/modules/contrib/search_api_solr/jump-start/drupal_configs/search_api.server.solr.yml` in Drupal or create your own search server using the Solr Cloud Connector and the collection default name `drupal`.
6. Edit the Search API Server and replace `localhost` by `[DDEV_SITENAME].ddev.site`
