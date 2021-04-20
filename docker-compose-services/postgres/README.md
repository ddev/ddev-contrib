# PostgreSQL

Using PostgreSQL container with [PostGIS](https://postgis.net/) support provided by [mdillon/postgis](https://hub.docker.com/r/mdillon/postgis).

## Installation

1. Copy `docker-compose.postgres.yaml` to your project
2. Copy the full `commands/postgres` directory to your project's `.ddev/commands` directory. For example `cp -r commands/postgres /.ddev/commands`
3. *(optional)* Update your config.yaml file to support auto-import/auto-export (see below)

## Connection

Connect to `postgres` host/db server from within the web container with:

```
Host: postgres
User: db
Password: db
Database: db
```

For external access, use the port used in your `docker-compose.postgres.yaml` and `127.0.0.1` as host.

When using multiple project with PostgreSQL support, remember to update your `docker-compose.postgres.yaml` to use different ports:

```
    ports:
      - <EXTERNAL_PORT>:5432
```

## Import / Export

Two new `ddev` commands are provided:

* `ddev pgsql_export` : Use `pg_dump` to export `db` to `.ddev/import-db/postgresql.db.sql`
* `ddev pgsql_import` : Use `pgsql` to import `.ddev/import-db/postgresql.db.sql` into `db` - Note that this must be executed with an empty database.

Example `config.yaml` hooks configuration to automatically import/export the `db` table:

```
# Add psql to your webserver
webimage_extra_packages: [postgresql-client]

# Automatically import and export PostgreSQL database on ddev start and stop
hooks:
  pre-stop:
    - exec-host: ddev pgsql_export
  post-start:
    - exec-host: ddev pgsql_import
```

There are also another non-plain-text formats that `pg_dump` can generate, and you might need to work with them. If that's the case, there is also
a `ddev pg_restore` command that will restore `.ddev/import-db/postgresql.db.dump` into `db`.

## PostGIS

The `postgres` image support `postgis`, but you will need to create the extension before using it:

```
CREATE EXTENSION IF NOT EXISTS `postgis`;
```

## Typo3 Notice

Typo3 CMS supports PostgreSQL natively, but the Typo3 Installer has issues with the default `db` database because the `postgis` extension is enabled per default.

You will need to disable the extension before the installation:

```
DROP EXTENSION postgis CASCADE;
```

It’s safe to re-enable `postgis` after the installation is complete.

## TODO

Future enhancements (PR's welcome here) include:

* Provide interactive custom commands to interact with the `postgres` utility in the container interactively.
* Consider changing suggested import/export hooks into "exec" hooks with "service: postgres" instead of running `ddev pg*` on the host.
