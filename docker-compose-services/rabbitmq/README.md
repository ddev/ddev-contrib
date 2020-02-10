# RabbitMQ

This enables a RabbitMQ service container that can be used by other containers on the same network and the host machine itself.

## Installation

1. Copy [docker-compose.rabbitmq.yaml](docker-compose.rabbitmq.yaml) to your project
2. Copy the directory [rabbitmq-build](rabbitmq-build) to your project.

The [rabbitmq-build](rabbitmq-build) directory contains the enabled plugins, these are required for having a functioning RabbitMQ service, as the container would otherwise stop itself shortly after starting. The plugins themselves are what enables the management UI and the graphs within it.

## Configuration

From within the container, the RabbitMQ container is reached at hostname: rabbitmq, port: 5672, so the server URL might be `amqp://rabbitmq:15672`.

For more details check the connection section below.

## Connection

RabbitMQ is accessible from the host machine itself as well as between the containers on the same network, and comes with a nice management UI for ease of use.

__Important:__ If you need to run multiple ddev sites that use this RabbitMQ service, you will have to alter the ports per site in the [docker-compose.rabbitmq.yaml](docker-compose.rabbitmq.yaml).

### Management UI

The management UI can be accessed through `http://<DDEV_SITENAME>.ddev.site:15672` on the host machine. Username "rabbitmq", password "rabbitmq".

### AMQP protocol access

You can access the RabbitMQ service through it's AMQP protocol two ways:

* From the host machine: `amqp://<DDEV_SITENAME>.ddev.site:5672`
* From docker containers on the same docker network (ddev_default): `amqp://rabbitmq:15672`

**Originally by [@Graloth](https://github.com/Graloth)**
