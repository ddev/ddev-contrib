# Install [Laravel](https://laravel.com/) with DDEV

## What is Laravel?
[Laravel](https://laravel.com/) is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.

## Install Laravel
In order to create a Laravel project follow the installation instructions [here](https://laravel.com/docs/master/installation).

## Configure ddev
* Use `ddev config --project-type=php` Laravel runs fine as a plain php project.
* Docroot location is `public` (default)

## Setup .env file
Laravel uses its `.env` file to hold its config. An example file can be found in the root of the repo as `.env.example`.

**NOTE:** If you have used the composer installer `composer create-project --prefer-dist laravel/laravel project-name` then the `.env` file will have been automatically created for you. This will also set the application key so there is no need to run `php artisan key:generate`.

Make a copy of the `.env.example` file and name it `.env` and update the database details to be:

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db
```

These would change if you set the db credentials to something else in `.ddev/docker-compose.yaml`

## Start up
* `ddev start`
* `ddev ssh`
* Run `php artisan key:generate` this sets the application key via [artisan](https://laravel.com/docs/master/artisan)
* Visit the site URL (like `https://laravel.ddev.local`) and you should see the default welcome page

