# Solr 5 integration with DDEV

The documented ApacheSolr integration with DDEV assumes a newer version of Solr.

With the default integration, Solr data from old versions is not stored in a Docker volume, so it is lost during each restart. This is because Solr changed where it stored its data at some point from `/opt/solr` to `/var/solr`.

The author of this document is not sure if we need both the new `/var/solr` directory and the legacy `/opt/solr` directory since both have files in them for Solr 5 and likely other versions as well.

## General documentation

[DDEV Integration documentation](https://ddev.readthedocs.io/en/stable/users/extend/additional-services/#apache-solr)

[Docker Solr documentation](https://hub.docker.com/_/solr/)

## Why support old versions?

At the time of writing, versions lower than 7 and 8 (current version) are end-of-life (EOL), or practically unsupported. So, why support Solr 5?

Some hosting providers provide only older versions or old sites are running on these unsupported versions and local development needs to match. This was created for a site that really needs a version older than 5, but 5 seems to match close-enough.

The Docker Solr integration currently supports versions as old as 5.

## Differences between default `docker-compose.solr.yaml`

These are the only changes. You can either make them manually or use the included file.

```
services.solr:
  image: solr:5
  volumes:
    - solr_var:/var/solr
    - solr_opt:/opt/solr
volumes:
  solr_var:
  solr_opt:
```

## Limitations

DDEV has a note that it will clean up volumes that match the service name. Since we have two volumes, they can't both match the service name, so that probably won't happen and you'll have to do that manually if it's a concern for you. DDEV creates standard Docker volumes, so they can be deleted with Docker by following standard documentation.

`docker volume ls` to list the volumes

`docker volume rm [volume name]` to remove a volume

You'll see two named something like `ddev-example_solr_opt` and `ddev-example_solr_var`.

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

* The browser may redirect to https://myproject.ddev.site:8983. This is a
  default behavior in Safari. The solution is to either load the page in a
  different browser, e.g. Firefox.

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

Contributed by [@damontgomery](https://github.com/damontgomery)
