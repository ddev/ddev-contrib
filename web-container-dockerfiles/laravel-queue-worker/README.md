# Laravel Queue Worker

## Run using supervisor

Run the Laravel queue worker as a process using supervisor. The included configuration file has been minimally changed from the example in the [Laravel docs](https://laravel.com/docs/7.x/queues#supervisor-configuration).

Copy `Dockerfile` and `laravel-worker.conf` to `.ddev/web-build` and restart using `ddev restart`.

Keep in mind that using this approach will modify your web image, so read the caveats in the DDEV docs under "Customizing Docker Images" > "Adding extra Dockerfiles for webimage and dbimage."

## Run in background using `nohup`

Copy `config.laravel-worker.conf` to `.ddev`. When the container is restarted, the queue worker will run in the background with no change to the Docker image.

**Contributed by [@karlshea](https://github.com/karlshea)**
