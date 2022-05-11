ARG BASE_IMAGE
FROM $BASE_IMAGE

ENV PATH="${PATH}:/opt/mssql-tools/bin"
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests apt-utils curl gnupg2 ca-certificates

RUN curl -sSL -O https://packages.microsoft.com/keys/microsoft.asc
RUN apt-key add <microsoft.asc
RUN curl -sSL -o /etc/apt/sources.list.d/mssql-release.list https://packages.microsoft.com/config/debian/11/prod.list

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests build-essential dialog php-pear php-dev unixodbc-dev locales

RUN ACCEPT_EULA=Y DEBIAN_FRONTEND=noninteractive apt-get install -y msodbcsql18 mssql-tools

# Change the PHP version to what you want. It is currently set to version 8.0.
RUN pecl channel-update pecl.php.net
RUN pecl -d php_suffix=8.0 install sqlsrv
RUN pecl -d php_suffix=8.0 install pdo_sqlsrv

RUN echo 'extension=sqlsrv.so' >> "/etc/php/8.0/mods-available/sqlsrv.ini"
RUN echo 'extension=pdo_sqlsrv.so' >> "/etc/php/8.0/mods-available/pdo_sqlsrv.ini"

RUN phpenmod sqlsrv pdo_sqlsrv
