ENV PHP_VERSION=$DDEV_PHP_VERSION
RUN \
    (apt-get update || true) && apt-get install -y libz-dev php-dev php-pear && \
    pecl install grpc && \
    pecl install protobuf && \
    echo "extension=grpc.so" > /etc/php/$DDEV_PHP_VERSION/cli/conf.d/grpc.ini && \
    echo "extension=protobuf.so" > /etc/php/$DDEV_PHP_VERSION/cli/conf.d/protobuf.ini  && \
    echo "extension=grpc.so" > /etc/php/$DDEV_PHP_VERSION/fpm/conf.d/grpc.ini  && \
    echo "extension=protobuf.so" > /etc/php/$DDEV_PHP_VERSION/fpm/conf.d/protobuf.ini
