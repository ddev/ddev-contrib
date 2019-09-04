#!/usr/bin/env bash

## Description: Restore MYSQL DB quick or from snapshot
## Usage: mysql-restore
## Example: "ddev mysql-restore"
## Options: "ddev mysql-restore mysql-db-20190828-1200.sql.gz   append Filename"

BACKUP_NAME=$1

if [[ ${BACKUP_NAME} ]]; then
    echo 'restore Snapshot' ${BACKUP_NAME}
    gunzip < /mnt/ddev_config/backup/${BACKUP_NAME} | mysql -udb -pdb db
else
    gunzip < /mnt/ddev_config/backup/mysql-db.sql.gz | mysql -udb -pdb db
fi
