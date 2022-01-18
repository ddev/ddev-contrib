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

* To configure the redis service config file as needed: `.ddev/redis/redis.conf`
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

**Contributed by [@gormus](https://github.com/gormus)**
