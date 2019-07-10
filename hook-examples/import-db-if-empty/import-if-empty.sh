#!/bin/bash

# Use a table that should exist in your database instead of "mytable"
if ! mysql -e 'SELECT * FROM mytable;' db > /dev/null; then
  echo 'loading db'
  # This assumes the db.sql.gz is in the root of your repository, but
  # adjust as necessary.
  gzip -dc /var/www/html/db.sql.gz | mysql db
fi
