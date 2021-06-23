# PHP8.1 (while in alpha/beta/etc)

DDEV-Local will directly support PHP 8.1 as soon as possible, but not likely until the full release in late 2021. At that time this recipe will be obsolete.

This version adds composer support as well as the gd, fileinfo, pdo_mysql, opcache, and curl extensions. More can easily be added in the php-build/Dockerfile.

In the meantime, you can use the [official docker php image](https://hub.docker.com/_/php) (currently php:8.1.0alpha1-fpm-buster) to serve PHP.  This can be updated as new versions come out.

1. Copy [docker-compose.php8_1.yaml](docker-compose.php8_1.yaml) to your project's .ddev folder.
2. Copy [nginx-site.conf](nginx-site.conf) to your .ddev/nginx_full directory (overwriting the generated file there)
3. Copy recursively the php-build directory to your project .ddev directory
4. `ddev start`

On some linux versions you may have to set the UID in the `user` section of the docker-compose.php.yaml.

Note that this introduces a container named `php`, which you can accesss via `ddev ssh -s php`. It has the exact same code mounted in the same place as in the `web` container, at `/var/www/html`.

You can `ddev exec -s php composer install` as well, and of course you can `ddev ssh -s php` to have full access to the container and work there.

You may find that your project has some problems with PHP8.1 or that PHP8 has some problems with your project :)

**Contributed by [@rfay](https://github.com/rfay)**
