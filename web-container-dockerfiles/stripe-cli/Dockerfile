
# Install the Stripe CLI
# Documentation: https://stripe.com/docs/stripe-cli#install

ARG BASE_IMAGE
FROM $BASE_IMAGE

RUN apt-key adv --keyserver hkp://pool.sks-keyservers.net:80 --recv-keys 379CE192D401AB61
RUN echo "deb https://dl.bintray.com/stripe/stripe-cli-deb stable main" | sudo tee -a /etc/apt/sources.list
RUN apt-get update
RUN apt-get install stripe
