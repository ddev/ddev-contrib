Writing a public summary of what we had to do to make DDEV work with a Drupal 7 site subfolder setup.

## Subfolder

A Drupal site might be operated from a subfolder (subdirectory) of a domain. Example for such a URL:
* No Subfolder frontpage: https://example.com
* Subfolder frontpage: https://example.com/jobs

That means the Drupal site only lives in the `/jobs` part. A reverse proxy sits in front of the production site and delivers requests either to the main page "/" or the Drupal site at "/jobs.

## Simulating a subfolder setup in DDEV

In order to have a development environment that mimics the production site subfolder as much as possible we want to run DDEV also with a URL subfolder. We need to change a couple of things for that.

Note that this setup only runs the /jobs subfolder site and ignore the main site completely.

### Demo repository with the .ddev config folder

See https://github.com/jobiqo/drupal7-subfolder

### Nginx

Nginx needs 2 rewrite rules for the `/jobs` subfolder (replace /jobs with your subfolder name). Modify `.ddev/nginx_full/nginx-site.conf` (see also https://ddev.readthedocs.io/en/stable/users/extend/customization-extendibility/#providing-custom-nginx-configuration )

```
# Rewrite the /jobs subfolder.
# Special rule for the front page: we need to pass "/" explicitly here to
# $_GET['q'] and PHP. This is not done by Nginx automatically and then
# Drupal falls back to the full request URI which would include the
# subfolder /jobs.
rewrite ^/jobs/?$    /index.php?q=/&$args   last;
rewrite ^/jobs/(.*)$   /$1   last;
```

Currently the Nginx site config also needs a single line change so that the subfolder works in the index.php location (see https://github.com/drud/ddev/pull/2267 ):

```
    location @rewrite {
        # For D7 and above:
        # Clean URLs are handled in drupal_environment_initialize().
        rewrite ^ /index.php?q=$uri&$args;
    }
```

See the full [nginx-site.conf](dot.ddev/nginx_full/nginx-site.conf)

### Base URL

We want the site to be reachable at https://example.ddev.site/jobs . We need to set the base URL for Drupal so achieve that. Add a settings.php copy hook in `.ddev/config.yaml`:

```
hooks:
  pre-start:
  - exec-host: cp -f sites/default/ddev-subfolder.settings.php sites/default/settings.php
```

Create [sites/default/ddev-subfolder.settings.php](sites/default/ddev-subfolder.settings.php):

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
