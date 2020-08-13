# Drupal 7 in a subfolder of a main site

This is a public summary of what we had to do to make DDEV work with a Drupal 7 site subfolder setup.

A Drupal site might be operated from a subfolder (subdirectory) of a domain. Example for such a URL:

* No Subfolder frontpage: `https://example.com`
* Subfolder frontpage: `https://example.com/jobs`

That means the Drupal site only lives in the `/jobs` part. A reverse proxy sits in front of the production site and delivers requests either to the main page "/" or the Drupal site at "/jobs.

The organization of your site might look like this, with a top-level index.html (or some full main site) and a subdirectory named "jobs" which contains a Drupal 7 site. DDEV is configured in the top-level directory:

```text
├── .ddev (Config for top-level site)
   └── config.yaml
   └── nginx_full
      └── nginx-site.conf
├── index.html (Top-level site)
├── jobs (Drupal 7 folder)
   ├── CHANGELOG.txt
   ├── README.txt
   ├── cron.php
   ├── index.php
   ├── install.php
   ├── modules
   ├── sites
   ├── themes
   └── xmlrpc.php
└── sites
    └── default
```

## Simulating a subfolder setup in DDEV

In order to have a development environment that mimics the production site subfolder as much as possible we want to run DDEV also with a URL subfolder. We need to change a couple of things for that.

An example top-level index.html might look like this:

```html
<h1>This is the main site</h1>
You could go to the <a href="jobs">JOBS</a> site if you wanted to. It's in a subdirectory.
```

### Demo repository with the .ddev config folder

See [https://github.com/jobiqo/drupal7-subfolder](https://github.com/jobiqo/drupal7-subfolder).

### Nginx

Nginx needs two rewrite rules for the `/jobs` subfolder (replace /jobs with your subfolder name). Change the provided [dot.ddev/nginx_full/nginx-site.conf](dot.ddev/nginx_full/nginx-site.conf)  to change "jobs" to the subdirectory you need, and put it in your project's `.ddev/nginx_full` directory. You could easily duplicate "jobs" with other subdirectories. See also [DDEV-Local nginx configuration docs](https://ddev.readthedocs.io/en/stable/users/extend/customization-extendibility/#providing-custom-nginx-configuration)

Copy the full [nginx-site.conf](dot.ddev/nginx_full/nginx-site.conf) into your project's .ddev/nginx_full directory (overwriting the ddev-generated one that may be there) and then change "jobs" to whatever your subdirectory is.

### Base URL

We want the site to be reachable at `https://example.ddev.site/jobs` . We need to set the base URL for Drupal so achieve that. Add a settings.php copy hook in `.ddev/config.yaml`:

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

## Contributed by [@klausi](https://github.com/klausi)
