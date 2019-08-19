## PostgreSQL

Using PostgreSQL container with PostGIS support provided by [mdillon/postgis
](https://hub.docker.com/r/mdillon/postgis).

### Connection

Connect to `pgsql` with

```
Host: postgres
User: db
Password: db
Database: db
```

### Auto-import / auto-export

To import/export the `db` table automatically add the following to your `config.yaml`:

```
hooks:
  pre-stop:
    - exec-host: ddev pgsql_export
  post-start:
    - exec-host: ddev pgsql_import
```

### PostGIS

The pgsql image support `postgis`, but you will need to create the extension before using it:

```
CREATE EXTENSION IF NOT EXISTS `postgis`;
```
