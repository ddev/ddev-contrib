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

Contributed by [@damontgomery](https://github.com/damontgomery)
