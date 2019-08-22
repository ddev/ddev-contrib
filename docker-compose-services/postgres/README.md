## PostgreSQL

Using PostgreSQL container with [PostGIS](https://postgis.net/) support provided by [mdillon/postgis](https://hub.docker.com/r/mdillon/postgis).

### Installation

1. Copy `docker-compose.postgres.yaml` to your project
2. Copy the full `commands/postgres` directory to your project's `.ddev/commands` directory. For example `cp -r commands/postgres /.ddev/commands`
3. *(optional)* Update your config.yaml file to support auto-import/auto-export (see below)

### Connection

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

### Import / Export

Two new `ddev` commands are provided:

- `ddev pgsql_export` : Use `pg_dump` to export `db` to `.ddev/import-db/postgresql.db.sql`  
- `ddev pgsql_import` : Use `pgsql` to import `.ddev/import-db/postgresql.db.sql` into `db` - Note that this must be executed with an empty database.

Example `config.yaml` hooks configuration to automatically import/export the `db` table:

```
hooks:
  pre-stop:
    - exec-host: ddev pgsql_export
  post-start:
    - exec-host: ddev pgsql_import
```

### PostGIS

The `postgres` image support `postgis`, but you will need to create the extension before using it:

```
CREATE EXTENSION IF NOT EXISTS `postgis`;
```

### TODO

Future enhancements (PR's welcome here) include:

* Non-volatile postgres database (store it on a docker volume like ddev's normal mariadb container does)
* Provide interactive custom commands to interact with the `postgres` utility in the container interactively.
* Consider changing suggested import/export hooks into "exec" hooks with "service: postgres" instead of running `ddev pg*` on the host.
