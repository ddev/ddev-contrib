# PHP8 (while in alpha/beta/etc)

DDEV-Local will directly support PHP8 as soon as possible, but not likely until the full release in late 2020. At that time this recipe will be obsolete.

In the meantime, you can use the [official docker php image](https://hub.docker.com/_/php) (currently php:8.0.0alpha3-fpm-buster) to serve PHP.  This can be updated as new versions come out.

1. Copy [docker-compose.php8.yaml](docker-compose.php8.yaml) to your project's .ddev folder.
2. Copy [nginx-site.conf](nginx-site.conf) to your .ddev/nginx_full directory (overwriting the generated file there)
3. `ddev start`

Note that this introduces a container named `php`, which you can accesss via `ddev ssh -s php`. It has the exact same code mounted in the same place as in the `web` container, at `/var/www/html`. The "php" container does not have composer or other tools installed, so they might need to be added.

For example, you'll probably want a composer running php8 if you're experimenting with this. You can add it with post-start hooks in your project's .ddev/config.yaml:

```yaml
hooks:
  post-start:
    - exec: php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" && php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
      service: php
#    To update to composer 2 snapshot
#    - exec: composer selfupdate --preview
#      service: php
#    To `composer install` with the php8 composer
#    - exec: composer install
#      service php
```

You can `ddev exec -s php composer install` as well, and of course you can `ddev ssh -s php` to have full access to the container and work there.

You may find that your project has some problems with PHP8 or that PHP8 has some problems with your project :)

**Contributed by [@rfay](https://github.com/rfay)**
