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
