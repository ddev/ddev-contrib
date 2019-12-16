# Import a sql dump if database is empty

## Use case

You want to import a sql dump automatically on `ddev start` if the database is empty so the user gets a full setup of the project.
Another case would be, that you are running `composer install` on `post-start` hook, but your composer setup requires some data from the database (e.g. on a TYPO3 setup).
`ddev start` will fail, as composer expects the data to be there and `ddev import-db` will also fail, as it needs the db container to be started, so it will simply run `ddev start` again.

## Solution

Run a bash script like [import-if-empty.sh](import-if-empty.sh) on a `post-start` hook, which looks for a table in the database that should always be there and imports a database dump if check fails.

The hook setup might look like this; adjust the path to the script. If it's in your code repository, the script will mounted into `/var/www/html/<relative_path>`.

```
hooks:
  post-start:
  - exec: /var/www/html/import-if-empty.sh
  - exec: echo 'other post-start hooks will now be executed'
```
