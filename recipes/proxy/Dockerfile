# This is a Dockerfile for use with the ddev-webserver image
# It should be in .ddev/web-build/Dockerfile
# and then you can expand on it.
ARG BASE_IMAGE=drud/ddev-webserver:v1.9.1
FROM $BASE_IMAGE
# If HTTP_PROXY is set in the docker environment, then add the same proxy configuration
# into apt system in the Debian-based ddev-webserver image at
# /etc/apt/apt.conf.d/proxy.conf
# This is only needed if the apt subsystem must be used *after* the image is built,
# for example in a post-start hook.
RUN if [ ! -z "${HTTP_PROXY}" ]; then printf "Acquire {\nHTTP::proxy \"$HTTP_PROXY\";\nHTTPS::proxy \"$HTTPS_PROXY\";\n}\n"  > /etc/apt/apt.conf.d/proxy.conf ; fi
# You can add additional Dockerfile build activities here.
