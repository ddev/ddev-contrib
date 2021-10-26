# Apache Solr (Cloud) Integration for DDEV-Local

Running Solr in single core mode is not the recommended way anymore. The "Solr
Cloud" mode is the preferred way and offers many additional features like
Streaming Expressions and APIs that make management easier. These APIs allow to
create and modify collections (cores), manage stopwords, synonyms etc.
All from Drupal via UI or drush, via the Solarium library or your custom code.
That’s a huge difference compared to Solr maintenance like you know it before!

In a production environment it is recommended to have at least three Solr nodes
that build that "cloud". In a development environment you can choose to only run
a single node in standalone mode to require less memory or CPU. DDEV offers both
options. You choose to run three nodes or a single node in standalone mode by
copying either `docker-compose.solr.yaml` or
`docker-compose.solr-standalone.yaml` to your project's `.ddev` folder.

Solr Cloud provides a lot of APIs to manage your collections, cores, schemas
etc. Some of these APIs require a so-called "trusted" context. Solr therefore
supports different technologies for authentication and authorization. The
easiest one to configure is "Basic Authentication". This DDEV service comes with
a simple pre-configured `security.json` to provide such a trusted context based
on basic authentication. It creates a single administrative account full access
rights:
* user: `solr`
* password: `SolrRocks`

Just copy the `solr` directory (including `security.json`) to your
project's `.ddev` folder. If required, you can adjust the username and the
password by editing the `security.json` file and restarting the service. But be
aware that the password is stored as a hash. Please consult the Solr
documentation for details. On the other hand our recommendation for a local
development environment is to just stay with the default.

Once up and running you can access Solr's UI within your browser by opening
`http://<projectname>.ddev.site:8983`. For example, if the project is named
"myproject" the hostname will be `http://myproject.ddev.site:8983`. To access
the Solr container from the web container use `ddev-<project>-solr:8983`.

Solr Cloud depends on Zookeeper to share configurations between the Solr nodes.
Therefore this service starts a single Zookeeper server on port 2181, too. It is
also required if you decide to run this service in standalone mode using a
single node only. But there's nothing you need to care about. This is just for
your information in case you wonder what that service is.

## Drupal and Search API Solr

For Drupal and Search API Solr you need to configure a Search API server using
Solr as backend and `Solr Cloud with Basic Auth` as its connector. As mentioned
above, username "solr" and password "SolrRocks" are the pre-configured
credentials for Basic Authentication in `.ddev/solr/security.json`.

Solr requires a Drupal-specific configset for any collection that should be used
to index Drupal's content. (In Solr Cloud "collections" are the equivalent to
"cores" in classic Solr installations. Actually a collection consists of
multiple cores sharded across all server nodes.)
Starting from Search API Solr module version 4.2.1 you don't need to deal with
configsets manually anymore. Just enable the `search_api_solr_admin` sub-module
which is part of Search API Solr. Now you create or update your "collections" at
any time by clicking the "Upload Configset" button on the Search API server
details page, or automate things using
```
ddev drush search-api-solr:upload-configset SERVER_ID NUMBER_OF_SHARDS
```

Note: If you choose to run Solr Cloud using a single node in standalone mode,
      you need to limit the number of "shards" to "1" when uploading the
      configset. There's a corresponding option in the UI and a parameter for
      the drush command.

## Installation step by step

1. Copy `docker-compose.solr.yaml` **or** `docker-compose.solr-standalone.yaml` to your project's `.ddev` directory.
2. Copy the `solr` folder (`including security.json`) to your project's `.ddev` directory.
3. Configure your application to connect Solr at `http://ddev-<project>-solr:8983`.
4. If you want to use Solr's APIs that require a trusted context configure Basic Auth with username `solr` and password `SolrRocks`.
5. (Re-)start your DDEV project.

## Solarium

[Solarium](https://github.com/solariumphp/solarium) is the leading Solr
integration library for PHP. It is used by the modules and integrations of many
PHP frameworks and CMS like Drupal, Typo3, Wordpress, Symfony, Laravel, ...
If you build your own PHP application and want to use Solarium directly, here is
an example of how to configure the connection in DDEV.

```php
use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

$adapter = new Curl();
$eventDispatcher = new EventDispatcher();
$config = [
    'endpoint' => [
        'localhost' => [
            // Replace <project> by your project's name:
            'host' => 'ddev-<project>-solr',
            'port' => 8983,
            'path' => '/',
            // Use your collection name here:
            'collection' => 'techproducts',
            'username' => 'solr',
            'password' => 'SolrRocks',
        )
    )
);

$client = new Solarium\Client($adapter, $eventDispatcher, $config);
```

## Drupal and Search API Solr (>= 4.2.1)

* Enable the `search_api_solr_admin` module. (This sub-module is included in Search API Solr >= 4.2.1)
* Create a search server using the Solr backend and select `Solr Cloud with Basic Auth` as connector:
  * HTTP protocol: `http`
  * Solr node: `ddev-<project>-solr` (Replace <project> by your project's name.)
  * Solr port: `8983`
  * Solr path: `/`
  * Default Solr collection: `techproducts` (You can define any name here. The collection will be created automatically.)
  * Username: `solr`
  * Password: `SolrRocks`
* Press the `Upload Configset` button on the server's view and check the "Upload (and overwrite) configset" checkbox.
* Set the number of shards to _3_ if you use `docker-compose.solr.yaml` or _1_ if you use `docker-compose.solr-standalone.yaml`.
* Press `Upload`.

### Drupal and Search API Solr 4.1 and older

It is highly recommended to upgrade to the 4.2 version. But if you're required
to use an older versions of the Search API Solr module you have to deploy the
configset manually and create a collection using this configset afterwards.
Therefore you need to use the `Download config.zip` function of Search API Solr.
Please consult the Solr documention about the different ways about how to deploy
configset archive and how to create a collection using it.


**Contributed by [@mkalkbrenner](https://github.com/mkalkbrenner)**
