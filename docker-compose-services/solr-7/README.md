# Solr 7 for DDEV

The documented ApacheSolr integration with DDEV assumes version 8 of Solr, but the Solr docker images have different configuration locations between versions of Solr. This means that the docker-compose file and `solr-configupdate.sh` script need to be tweaked for use with Solr 7.

## General documentation

* [DDEV Integration documentation](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr)
* [Docker Solr documentation](https://hub.docker.com/_/solr/)

## Installation

1. Copy the `docker-compose.solr.yaml` file and the `solr/` directory into your `.ddev/` directory
2. Copy your desired solr core configuration into the `.ddev/solr/conf/` directory
  * You may be able to download your hosting provider's default core configuration
  * You can also use the [jump start configuration](https://git.drupalcode.org/project/search_api_solr/-/tree/4.x/jump-start/solr7/config-set) from `search_api_solr` module
3. Start (or restart) ddev

**Note:** If you had a different version of solr running before, you'll need to delete the previous Solr docker volume so that the Solr 7 one can be created:

1. Use `docker volume ls` to list the volumes
2. Identify your Solr volume -- it will be named with the pattern `ddev-example_solr`
3. Use `docker volume rm [volume name]` to remove the volume

## Differences between default `docker-compose.solr.yaml`

If you don't want to follow the installation steps above, you can make these changes manually:

```
services.solr:
  image: solr:7
  volumes:
    - solr:/opt/solr
```

You'll also need to use the updated `solr-configupdate.sh` script, because the Solr 7 image uses the directory `/opt/solr/server/solr/mycores/${CORENAME}/conf`, which is different from some other versions.

**Contributed by [@becw](https://github.com/becw)**
