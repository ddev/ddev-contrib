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

## Creating search indexes

The `ddev start` process should create the 'dev' index the first time it the
project is started. However, in certain circumstances this does not happen.
The solution is to manually create the index from the server:

    $ ddev ssh --service solr
    $ bin/solr create_core -c dev -d /solr-conf

This uses the Solr configuration files which ddev makes available from the path `/solr-conf` and creates an index named `dev`; it should result in the following output:

    Copying configuration to new core instance directory:
    /opt/solr/server/solr/dev
    
    Creating new core 'dev' using command:
    http://localhost:8983/solr/admin/cores?action=CREATE&name=dev&instanceDir=dev
    
    {
      "responseHeader":{
        "status":0,
        "QTime":1580},
      "core":"dev"}

To create a additional indexes just change the `dev` portion of the command
above, e.g.

    $ ddev ssh --service solr
    $ bin/solr create_core -c myindex -d /solr-conf

## Troubleshooting

If the Solr service is not available to the client project (e.g. Drupal) using
the expected URL format, the Solr index may not have been created correctly. It
is possible to access Solr directly from the host OS by loading its full URL,
e.g. `http://myproject.ddev.site:8983`.

* The brower may redirect to https://myproject.ddev.site:8983. This is a
  default behavior in Safari. The solution is to either load the page in a
  different browser, e.g. Firefox, or load the site from the HTTPS port:
  https://myproject.ddev.site:8984
* If https://myproject.ddev.site:8984 does not work make sure that the
  `HTTPS_EXPOSE=8984` line is present in the `docker-compose.solr.yml` file,
  per the example in this directory.

Once http://myproject.ddev.site:8983 or http://myproject.ddev.site:8984 loads
correctly it will redirect the browser to
http://myproject.ddev.site:8983/solr/#/ or
https://myproject.ddev.site:8984/solr/#/, which is the main dashboard page for
Solr. From here it is possible to see how much memory and swap space the system
is using.

To see if the index was created correctly click on the "Core Admin" link on the
left menu (underneath "Dashboard" and "Logging"). This page should list the
`dev` index, including when it was last updated ("lastModified") and the number
of records in the index ("numDocs").

If the `dev` index is not listed, follow the instructions above to create it,
then try reloading the admin page to confirm it was created as expected.

**Contributed by [@becw](https://github.com/becw)**
