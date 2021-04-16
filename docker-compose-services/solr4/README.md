# Solr 4.x

This recipe allows you to configure a [Solr](https://lucene.apache.org/solr/) server for your project using version 4.

The Solr version used in this recipe is 4.10.4 which is not supported officially anymore.

To enable Solr in your project follow these steps:

1. Create a directory named _solr_ in your project's `.ddev` directory.
1. Copy [docker-compose.solr.yml](docker-compose.solr.yml) into `.ddev/solr`.
1. Copy the [core.properties](core.properties) into `.ddev/solr` and edit it according to your needs.
1. Create a new directory `.ddev/solr/data`.
1. Copy the configuration suitable for Solr 4.x (including `schema.xml` and `solrconfig.xml`) into a new directory named `.ddev/solr/conf`.
1. Run `ddev start`.

You now have a running Solr instance for your project. To get the URL for the instance run `ddev describe`.

By default the Solr core is named "dev" and the host is named "solr" so applications running inside the web container will be able to access the Solr service at `http://solr:8983`.

> **Note**
>
> If you change the name of the core in [core.properties](core.properties) you also need to update the name in [docker-compose.solr.yml](docker-compose.solr.yml), section "services > solr > volumes".

--- 

Special thanks to [Jeff Geerling](https://www.jeffgeerling.com/) for building [Docker images](https://hub.docker.com/r/geerlingguy/solr) using versions of Apache Solr that have been deprecated long time ago.
