#!/bin/bash
# Installs the Regex database function for compatibility with Drupal version 9 or higher.
# This script only needs to be run once for a database.

usage() { echo "./install-drupal-regex-function.sh -u <username> -p <password> -d <database>" 1>&2; exit 1; }

# The password for the database defaults to ""
password=""

# The username for the database defaults to "SA"
username="SA"

# The database name defaults to "master"
database="master"

while getopts ":u:p:d:h:" arg; do
  case $arg in
    u)
      username=${OPTARG}
      ;;
    p)
      password=${OPTARG}
      ;;
    d)
      database=${OPTARG}
      ;;
    h)
      usage
      ;;
    *)
      usage
      ;;
  esac
done

if [ -z $password ]
then
  echo "The parameter -p for the password is not set."
  exit 1
fi

if ! ddev exec -s sqlsrv test -e "/RegEx.dll" &>/dev/null;
then
  # Download the Regex.dll file and copy it to the right location.
  ddev exec -s sqlsrv wget https://github.com/Beakerboy/drupal-sqlsrv-regex/releases/download/1.0/RegEx.dll
fi

# The following are changed to allow the installation and execution of the user provided database function.
ddev exec -s sqlsrv "/opt/mssql-tools/bin/sqlcmd -P $password -S localhost -U $username -d $database -Q 'EXEC sp_configure \"show advanced options\", 1; RECONFIGURE; EXEC sp_configure \"clr strict security\", 0; RECONFIGURE; EXEC sp_configure \"clr enable\", 1; RECONFIGURE;'"

# Create the assambly and the function for the Regex helper.
ddev exec -s sqlsrv "/opt/mssql-tools/bin/sqlcmd -P $password -S localhost -U $username -d $database -Q 'CREATE ASSEMBLY Regex from \"/RegEx.dll\" WITH PERMISSION_SET = SAFE'"
ddev exec -s sqlsrv "/opt/mssql-tools/bin/sqlcmd -P $password -S localhost -U $username -d $database -Q 'CREATE FUNCTION dbo.REGEXP(@pattern NVARCHAR(100), @matchString NVARCHAR(100)) RETURNS bit EXTERNAL NAME Regex.RegExCompiled.RegExCompiledMatch'"

# **Contributed by [@drupal-daffie](https://github.com/drupal-daffie)**
