## Import a sql dump if database is empty

**Use case:** 

You want to import a sql dump automatically on `ddev start` if the database is empty so the user gets a full setup of the project. 
Another case would be, that you are running `composer install` on `post-start` hook, but your composer setup requires some data from the database (e.g. on a TYPO3 setup). 
`ddev start` will fail, as composer expects the data to be there and `ddev import-db` will also fail, as it needs the db container to be started, so it will simply run `ddev start` again.

**Solution:**
 
Run a bash script on `post-start` hook, which looks for a table in the database that should always be there and imports a database dump if check fails:

``` bash
#!/bin/bash

if ! mysql -e 'SELECT * FROM mytable;' db > /dev/null; then
  echo 'loading db'
  gzip -dc /var/www/html/db.sql.gz | mysql db
fi
```
