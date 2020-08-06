# PHP8 (while in alpha/beta/etc)

DDEV-Local will directly support PHP8 as soon as possible, but not likely until the full release in late 2020. At that time this recipe will be obsolete.

In the meantime, you can use the [official docker php image](https://hub.docker.com/_/php) (currently php:8.0.0alpha3-fpm-buster) to serve PHP.  This can be updated as new versions come out.

1. Copy [docker-compose.php8.yaml](docker-compose.php8.yaml) to your project's .ddev folder.
2. Copy [nginx-site.conf](nginx-site.conf) to your .ddev/nginx_full directory (overwriting the generated file there)
3. `ddev start`

You may find that your project has some problems with PHP8 or that PHP8 has some problems with your project :)

**Contributed by [@rfay](https://github.com/rfay)**
