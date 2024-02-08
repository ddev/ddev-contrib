ARG odbc_version=2.3.7

ENV PATH="${PATH}:/opt/mssql-tools/bin"
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests apt-utils curl gnupg2 ca-certificates

RUN curl -sSL -O https://packages.microsoft.com/keys/microsoft.asc
RUN apt-key add <microsoft.asc
RUN curl -sSL -o /etc/apt/sources.list.d/mssql-release.list https://packages.microsoft.com/config/debian/11/prod.list

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y -o Dpkg::Options::="--force-confold" --no-install-recommends --no-install-suggests \
    build-essential \
    dialog \
    php-pear \
    php$DDEV_PHP_VERSION-dev \
    unixodbc=$odbc_version \
    odbcinst=$odbc_version \
    odbcinst1debian2=$odbc_version \
    unixodbc-dev=$odbc_version \
    locales

RUN ACCEPT_EULA=Y DEBIAN_FRONTEND=noninteractive apt-get install -y msodbcsql18 mssql-tools

# Change the PHP version to what you want. It is currently set to version 8.0.
RUN pecl channel-update pecl.php.net
RUN pecl -d php_suffix=$DDEV_PHP_VERSION install sqlsrv
RUN pecl -d php_suffix=$DDEV_PHP_VERSION install pdo_sqlsrv

RUN echo 'extension=sqlsrv.so' >> /etc/php/$DDEV_PHP_VERSION/mods-available/sqlsrv.ini
RUN echo 'extension=pdo_sqlsrv.so' >> /etc/php/$DDEV_PHP_VERSION/mods-available/pdo_sqlsrv.ini

RUN phpenmod -v $DDEV_PHP_VERSION sqlsrv pdo_sqlsrv
