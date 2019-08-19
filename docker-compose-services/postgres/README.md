## PostgreSQL

Using PostgreSQL container with PostGIS support provided by [mdillon/postgis
](https://hub.docker.com/r/mdillon/postgis).

### Installation

1. Copy `docker-compose.postgres.yaml` to your project
2. Copy `command/postgres` to your project
3. *(optional)* Update your config.yaml file to support auto-import/auto-export (see bellow)

### Connection

Connect to `postgres` with

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

- `ddev pgsql_export` : Use `pg_dump` to export `db` to `import-db/postgresql.db.sql` 
- `ddev pgsql_import` : Use `pgsql` to import `import-db/postgresql.db.sql` into `db`

To import/export the `db` table automatically add the following hooks to your `config.yaml`:

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
