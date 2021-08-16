# Solr 4.x

This recipe allows you to configure a [Solr](https://lucene.apache.org/solr/) server for your project using version 4.

The Solr version used in this recipe is 4.10.4 which is not supported officially anymore.

To enable Solr in your project follow these steps:

1. Create a directory named _solr_ in your project's `.ddev` directory.
1. Copy [docker-compose.solr.yml](docker-compose.solr.yml) into `.ddev`.
1. Copy the [core.properties](core.properties) into `.ddev/solr` and edit it according to your needs.
1. Create a new directory `.ddev/solr/data`.
1. Copy the configuration suitable for Solr 4.x (including `schema.xml` and `solrconfig.xml`) into a new directory named `.ddev/solr/conf`.
1. Run `ddev start`.

You now have a running Solr instance for your project. To get the URL for the instance run `ddev describe`.

By default the Solr core is named "dev" and the host is named "solr" so applications running inside the web container will be able to access the Solr service at `http://solr:8983`; an alternative format will be displayed via `ddev describe`, e.g. `http://myproject.ddev.site:8983`.

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

## Notes

If you change the name of the core in [core.properties](core.properties) you also need to update the name in [docker-compose.solr.yml](docker-compose.solr.yml), section "services > solr > volumes".

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

--- 

Special thanks to [Jeff Geerling](https://www.jeffgeerling.com/) for building [Docker images](https://hub.docker.com/r/geerlingguy/solr) using versions of Apache Solr that have been deprecated long time ago.
