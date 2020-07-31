#!/bin/bash

# Set TABLETOFIND to a table which should exist in a loaded database
TABLETOFIND=users

if ! mysql -e "SELECT * FROM ${TABLETOFIND};" db >/dev/null 2>&1; then
  echo "loading database since table named '${TABLETOFIND}' was not found."
  # This assumes the db.sql.gz is in the root of your repository, but
  # adjust as necessary.
  gzip -dc /var/www/html/.tarballs/d8composer.sql.gz | mysql db
else
  echo "NOT loading database; it already exists; table '${TABLETOFIND}' was found."
fi
