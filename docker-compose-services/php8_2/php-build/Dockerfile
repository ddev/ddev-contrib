ARG BASE_IMAGE
FROM $BASE_IMAGE
ENV PHP_EXTENSIONS="curl fileinfo gd pdo_mysql"
SHELL ["bash", "-c"]

RUN apt-get update -qq && apt-get install -y -qq build-essential less libpng-dev netcat procps telnet vim zlib1g-dev
RUN set -eu -o pipefail && for extension in ${PHP_EXTENSIONS}; do \
  docker-php-ext-configure ${extension} && docker-php-ext-install ${extension}; \
  done
RUN curl -o /usr/local/bin/composer -sSL https://getcomposer.org/composer-stable.phar && chmod ugo+wx /usr/local/bin/composer
COPY /usr /usr
