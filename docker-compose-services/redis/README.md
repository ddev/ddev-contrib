# Redis

This recipe adds a Redis container to a project.

## Installation

* Copy `docker-compose.redis.yaml` to the `.ddev` folder of your project.
* Copy `commands/redis/redis-cli` to the commands folder of your project DDEV folder: `.ddev/commands/redis/redis-cli` (make sure it's executable.)
* Add *redis-tools* to the list of webimage_extra_packages in `config.yaml`: `webimage_extra_packages: [redis-tools]`
* Start (or restart) DDEV to have the service initialized: `ddev start`
