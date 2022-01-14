#!/bin/bash

## Description: Launch a browser and login to the current Drupal project.
## Usage: login [--name=USER]
## Example: "ddev login" or "ddev login --name=username" or "ddev login --uid=1"

FULLURL=${DDEV_PRIMARY_URL}
HTTPS=""
if [ ${DDEV_PRIMARY_URL%://*} = "https" ]; then HTTPS=true; fi
FULLURL=`ddev drush uli ${1}`

case $OSTYPE in
  linux-gnu)
    xdg-open ${FULLURL}
    ;;
  "darwin"*)
    open ${FULLURL}
    ;;
  "win*"* | "msys"*)
    start ${FULLURL}
    ;;
esac
