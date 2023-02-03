# Laravel: Horizon

This is an step-by-step guide to install [Laravel Horizon](https://laravel.com/docs/master/horizon) into your project.
This expects the project to already have an working laravel project.

## Steps

1. Install redis using
   the [service example](https://github.com/ddev/ddev-contrib/blob/master/docker-compose-services/redis)
2. Configure the redis configuration in `.env`
3. Run `ddev composer require laravel/horizon`
4. Run `ddev artisan horizon:install`
5. Run horizon process in DDEV Installation

    * Option A: Run using nohup

      Copy the `dot.ddev/config.laravel-horizon.yaml` into your project's .ddev directory, or incorporate it into your .ddev/config.yaml. This snipped uses a post-start hook to use artisan to start the horizon process.

    * Option B: Run using supervisor

      Use both `dot.ddev/web-build/Dockerfile` and `dot.ddev/web-build/horizon.conf`

6. Run `ddev restart`
7. Configure your horizon configuration to your liking; see horizon documentation for reference

You are set! As configured in the supervisor or nohup command the logs are written in `/storage/logs/horizon.log`.

**Inspired
by [laravel-queue-worker](https://github.com/ddev/ddev-contrib/blob/master/web-container-dockerfiles/laravel-queue-worker)
by [@karlshea](https://github.com/karlshea)**

**Contributed by [@bmoex](https://github.com/bmoex)**
