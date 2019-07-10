# This is a Dockerfile for use with the ddev-webserver image
# It should be in .ddev/web-build/Dockerfile
# and then you can expand on it.
ARG BASE_IMAGE=drud/ddev-webserver:v1.9.1
FROM $BASE_IMAGE
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y php-mongodb
# You can add additional Dockerfile build activities here.
