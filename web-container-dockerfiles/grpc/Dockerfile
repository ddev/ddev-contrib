ARG BASE_IMAGE
FROM $BASE_IMAGE

ENV PHP_VERSION=7.4
RUN \
    apt-get update && apt-get install -y libz-dev php-dev php-pear && \
    pecl install grpc && \
    pecl install protobuf && \
    echo "extension=grpc.so" > /etc/php/7.4/cli/conf.d/grpc.ini && \
    echo "extension=protobuf.so" > /etc/php/7.4/cli/conf.d/protobuf.ini  && \
    echo "extension=grpc.so" > /etc/php/7.4/fpm/conf.d/grpc.ini  && \
    echo "extension=protobuf.so" > /etc/php/7.4/fpm/conf.d/protobuf.ini
