# Redis

This recipe adds a Redis container to a project.

## Installation

* Copy the `commands/redis` directory to the commands folder of your project DDEV folder; you should end up with `.ddev/commands/redis/redis-cli` (make sure it's executable, `chmod +x .ddev/commands/redis/redis-cli`.)
* Update the example redis configuration file to your needs: `.ddev/redis/redis.conf`.
* Start (or restart) DDEV to have the service initialized: `ddev start`

Now you can use `ddev redis-cli` to access the redis cli in the redis container.

**Contributed by [@gormus](https://github.com/gormus)**
