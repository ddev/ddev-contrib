Writing a public summary of what we had to do to make DDEV work with a Drupal 7 site subfolder setup.

## Subfolder

A Drupal site might be operated from a subfolder (subdirectory) of a domain. Example for such a URL:
* No Subfolder frontpage: https://example.com
* Subfolder frontpage: https://example.com/jobs

That means the Drupal site only lives in the `/jobs` part. A reverse proxy sits in front of the site and delivers requests either to the main page "/" or the Drupal site at "/jobs.

## Simulating a subfolder setup in DDEV

In order to have a development environment that mimics the production site subfolder as much as possible we want to run DDEV also in a subfolder. We need to change a couple of things for that.

### Nginx

Nginx needs 2 rewrite rules for the `/jobs` subfolder (replace /jobs with your subfolder name). Create `.ddev/nginx/subfolder.conf` (see also https://ddev.readthedocs.io/en/stable/users/extend/customization-extendibility/#providing-custom-nginx-configuration )

```
# Rewrite the /jobs subfolder.
# Special rule for the front page: we need to pass "/" explicitly here to
# $_GET['q'] and PHP. This is not done by Nginx automatically and then
# Drupal falls back to the full request URI which would include the
# subfolder /jobs.
rewrite ^/jobs/?$    /index.php?q=/&$args   last;
rewrite ^/jobs/(.*)$   /$1   last;
```

Currently the Nginx site config also needs a single line change so that the subfolder works (see https://github.com/drud/ddev/pull/2267 ). Create `.ddev/nginx-site.conf`:

```
# This file is overridden from DDEV because we need Nginx customizations for the
# /jobs subfolder setup.

# Set https to 'on' if x-forwarded-proto is https
map $http_x_forwarded_proto $fcgi_https {
    default off;
    https on;
}

server {
    listen 80; ## listen for ipv4; this line is default and implied


    # The WEBSERVER_DOCROOT variable is substituted with
    # its value when the container is started.
    root $WEBSERVER_DOCROOT;

    include /etc/nginx/monitoring.conf;


    # The following part is copied and modified from
    # https://github.com/drud/ddev/blob/master/containers/ddev-webserver/files/etc/nginx/nginx_drupal7.conf
    # Replaced @rewrite location content with
    # rewrite ^ /index.php?q=$uri&$args;
    # MODIFIED COPY START

    index index.php index.htm index.html;

    # Make site accessible from http://localhost/
    server_name _;

    # Disable sendfile as per https://docs.vagrantup.com/v2/synced-folders/virtualbox.html
    sendfile off;
    error_log /dev/stdout info;
    access_log /var/log/nginx/access.log;

    location / {
        absolute_redirect off;

        # First attempt to serve request as file, then
        # as directory, then fall back to index.html
        try_files $uri $uri/ /index.php?q=$uri&$args;
    }

    location @rewrite {
        # For D7 and above:
        # Clean URLs are handled in drupal_environment_initialize().
        rewrite ^ /index.php?q=$uri&$args;
    }

    # Handle image styles for Drupal 7+
    location ~ ^/sites/.*/files/styles/ {
        try_files $uri @rewrite;
    }

    # pass the PHP scripts to FastCGI server listening on socket
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php-fpm.sock;
        fastcgi_buffers 16 16k;
        fastcgi_buffer_size 32k;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param SCRIPT_NAME $fastcgi_script_name;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_intercept_errors off;
        # fastcgi_read_timeout should match max_execution_time in php.ini
        fastcgi_read_timeout 10m;
        fastcgi_param SERVER_NAME $host;
        fastcgi_param HTTPS $fcgi_https;
    }

    # Expire rules for static content
    # Feed
    location ~* \.(?:rss|atom)$ {
        expires 1h;
    }

    # Media: images, icons, video, audio, HTC
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        try_files $uri @rewrite;
        expires max;
        log_not_found off;
    }

    # Prevent clients from accessing hidden files (starting with a dot)
    # This is particularly important if you store .htpasswd files in the site hierarchy
    # Access to `/.well-known/` is allowed.
    # https://www.mnot.net/blog/2010/04/07/well-known
    # https://tools.ietf.org/html/rfc5785
    location ~* /\.(?!well-known\/) {
        deny all;
    }

    # Prevent clients from accessing to backup/config/source files
    location ~* (?:\.(?:bak|conf|dist|fla|in[ci]|log|psd|sh|sql|sw[op])|~)$ {
        deny all;
    }

    ## Regular private file serving (i.e. handled by Drupal).
    location ^~ /system/files/ {
        ## For not signaling a 404 in the error log whenever the
        ## system/files directory is accessed add the line below.
        ## Note that the 404 is the intended behavior.
        log_not_found off;
        access_log off;
        expires 30d;
        try_files $uri @rewrite;
    }

    # MODIFIED COPY END

    include /mnt/ddev_config/nginx/*.conf;
}

server {
    listen 443 ssl;


    # The WEBSERVER_DOCROOT variable is substituted with
    # its value when the container is started.
    root $WEBSERVER_DOCROOT;

    ssl_certificate /etc/ssl/certs/master.crt;
    ssl_certificate_key /etc/ssl/certs/master.key;

    include /etc/nginx/monitoring.conf;

    # TODO It seems this server is unused even under HTTPS, why?

    include /etc/nginx/nginx_drupal7.conf;
    include /mnt/ddev_config/nginx/*.conf;
}
```

### Base URL

We want the site to be reachable at https://example.ddev.site/jobs . We need to set the base URL for Drupal so achieve that. Add a settings.php copy hook in `.ddev/config.yaml`:

```
hooks:
  pre-start:
  - exec-host: cp -f sites/default/settings.ddev-custom.php sites/default/settings.php
```

Create sites/default/settings.ddev-custom.php:

```php
<?php

// Include ddev generated file.
$ddev_settings = dirname(__FILE__) . '/settings.ddev.php';
if (is_readable($ddev_settings)) {
  require $ddev_settings;
}

// This project is in a URL subfolder.
$subfolder = '/jobs';
// Behat tests run under HTTP, use that scheme if used in the request.
$http_scheme = 'http';
if (drupal_is_https() || PHP_SAPI === 'cli') {
  $http_scheme = 'https';
}
$base_url = "$http_scheme://" . getenv('VIRTUAL_HOST') . $subfolder;

// Return an empty page for the main site outside the subfolder. This helps
// detecting errors during subfolder development.
if (PHP_SAPI !== 'cli' && strpos(request_uri(), $subfolder) !== 0) {
  http_response_code(404);
  print "This is the main site, please go to the subfolder <a href=\"$base_url\">$base_url</a>";
  exit;
}
```

That should be it!
