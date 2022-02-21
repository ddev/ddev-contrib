# Redis

This recipe adds a Redis container to a project. See the [offical `redis` image](https://hub.docker.com/_/redis) page for supported versions and help.

## Installation

* Copy the files in this folder (you can skip `readme.md`) into your project's `.ddev` folder. Your project's `.ddev` should contain these additional files.

```
.ddev/
┣ commands/
┃ ┣ redis/
┃ ┃ ┗ redis-cli
┣ redis/
┃ ┗ redis.conf
┗ docker-compose.redis.yaml
```

* Make sure the `redis-cli` command is executable

```shell
chmod +x .ddev/commands/redis/redis-cli
```

* To change the redis version, update the `image` line in `.ddev/docker-compose.redis.yaml`. EG. To use redis version `6`,

```yaml
# docker-compose.redis.yaml
services:
  redis:
    image: redis:6
```

* The redis service can be configured in the following file as needed: `.ddev/redis/redis.conf`
* Start (or restart) DDEV to have the service initialized: `ddev start` (`ddev restart`)
* Your redis instance is available **inside the containers** at `ddev-<DDEV_SITENAME>-redis:6379`:
  * Host: `ddev-${DDEV_SITENAME}-redis`
  * Port: `6379`

## Usage

The follow command are available from your **host operating system**.

* Run `ddev redis-cli` to access the redis cli.

```shell
ddev redis-cli
```

* Run `ddev describe` to check the status and ports used by the service.

```shell
$ ddev describe
...
├──────────┬──────┬─────────────────────────────────────────┬───────────────────────┤
│ SERVICE  │ STAT │ URL/PORT                                │ INFO                  │
├──────────┼──────┼─────────────────────────────────────────┼───────────────────────┤
│ redis    │ OK   │ https://example.ddev.site               │                       │
│          │      │ InDocker: ddev-example-redis:6379       │                       │
│          │      │ Host: localhost:54710                   │                       │
```

## Examples

Frameworks, such as Laravel, require configuration to use the redis service.

### Laravel

Laravel can be configured to use the redis service as the cache driver.

* Update the `.env` file.

```env
CACHE_DRIVER=redis
REDIS_HOST=ddev-<DDEV_SITENAME>-redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

* You can check your `REDIS_HOST` by running `ddev describe`; under the redis section, look for `InDocker` line.

```shell
$ ddev describe
```

* Clear all caches with the following command:

```shell
$ ddev artisan optimize:clear
Compiled views cleared!
Application cache cleared!
Route cache cleared!
Configuration cache cleared!
Compiled services and packages files removed!
Caches cleared successfully!
```
**Contributed by [@gormus](https://github.com/gormus)**
