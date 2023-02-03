# Redis Commander

**Deprecated in favor of https://github.com/ddev-redis-commander: `ddev get ddev/ddev-redis-commander`**

This recipe adds a Redis Commander container to a project.

This will allow you to have a graphical interface for browsing data in your Redis server.

## Requirements

Redis Commander requires that there is a container within the project that has a working instance of Redis running for it to connect to.

## Configuration

If your redis server is not available on host `redis` on port `6379`, then you need to edit `docker-compose.redis-commander.yaml` and edit the following environment variables:

* Change `REDIS_PORT` to the port your redis server is available at.
* Change `REDIS_HOST` to `ddev-<project>-redis`.

## Installation

* Copy `docker-compose.redis-commander.yaml` to the `.ddev` folder of your project.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* Access your redis-commander UI at `http://<DDEV_STENAME>.ddev.site:1358` or `https://<DDEV_SITENAME>.ddev.site:1359`

## Notes

This service example is made to work with the redis service example out-of-the-box, as such you might need to do some additional tweaking to either your redis server or this service if you are using a different redis server.

**Contributed by [@Graloth](https://github.com/Graloth)**
