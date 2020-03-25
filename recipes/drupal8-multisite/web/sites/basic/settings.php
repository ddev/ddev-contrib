<?php

if (file_exists($app_root . '/sites/default/settings.base.php')) {
  include $app_root . '/sites/default/settings.base.php';
}

$databases['default']['default']['database'] = 'basic';
