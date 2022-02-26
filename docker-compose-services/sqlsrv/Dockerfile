ARG BASE_IMAGE
FROM $BASE_IMAGE

ENV PATH="${PATH}:/opt/mssql-tools/bin"
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests apt-utils curl gnupg2 ca-certificates

RUN curl -sSL -O https://packages.microsoft.com/keys/microsoft.asc
RUN apt-key add <microsoft.asc
RUN curl -sSL -o /etc/apt/sources.list.d/mssql-release.list https://packages.microsoft.com/config/debian/11/prod.list

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests build-essential dialog php-pear php-dev unixodbc-dev locales

RUN ACCEPT_EULA=Y DEBIAN_FRONTEND=noninteractive apt-get install -y msodbcsql18 mssql-tools

RUN pecl channel-update pecl.php.net && pecl install sqlsrv && pecl install pdo_sqlsrv

RUN for v in 7.4 8.0 8.1; do \
  echo 'extension=sqlsrv.so' >> "/etc/php/${v}/mods-available/sqlsrv.ini"; \
  echo 'extension=pdo_sqlsrv.so' >> "/etc/php/${v}/mods-available/pdo_sqlsrv.ini" ; \
done
RUN phpenmod sqlsrv pdo_sqlsrv
