<?php
/**
 * Default configuration for Xhgui
 */
return [
  'mode' => 'production',

  // Can be either mongodb or file.
  /*
  'save.handler' => 'file',
  'save.handler.filename' => dirname(__DIR__) . '/cache/' . 'xhgui.data.' . microtime(true) . '_' . substr(md5($url), 0, 6),
  */
  'save.handler' => 'mongodb',

  // Needed for file save handler. Beware of file locking. You can adjust this file path
  // to reduce locking problems (eg uniqid, time ...)
  //'save.handler.filename' => __DIR__.'/../data/xhgui_'.date('Ymd').'.dat',
  // Database options for MongoDB.
  'mongodb' => [
    // 'hostname' and 'port' are used to build DSN for MongoClient
    'hostname' => getenv('XHGUI_MONGO_HOSTNAME') ?: 'xhgui-mongo',
    'port' => getenv('XHGUI_MONGO_PORT') ?: 27017,
    // The database name
    'database' => getenv('XHGUI_MONGO_DATABASE') ?: 'xhprof',
    // Additional options for the MongoClient constructor,
    // for example 'username', 'password', or 'replicaSet'.
    // See <https://www.php.net/mongoclient_construct#options>.
    'options' => [],
    // An array of options for the MongoDB driver.
    // Options include setting connection context options for SSL or logging callbacks.
    // See <https://www.php.net/mongoclient_construct#options>.
    'driverOptions' => [],
  ],

  'run.view.filter.names' => [
    'Zend*',
    'Composer*',
  ],
  // If defined, add imports via upload (/run/import) must pass token parameter with this value
  'upload.token' => getenv('XHGUI_UPLOAD_TOKEN') ?: '',

  // Add this path prefix to all links and resources
  // If this is not defined, auto-detection will try to find it itself
  'path.prefix' => null,

  // Setup timezone for date formatting
  // Example: 'UTC', 'Europe/Tallinn'
  // If left empty, php default will be used (php.ini or compiled in default)
  'timezone' => '',

  // Date format used when browsing XHGui pages.
  //
  // Must be a format supported by the PHP date() function.
  // See <https://secure.php.net/date>.
  'date.format' => 'M jS H:i:s',

  // The number of items to show in "Top lists" with functions
  // using the most time or memory resources, on XHGui Run pages.
  'detail.count' => 6,

  // The number of items to show per page, on XHGui list pages.
  'page.limit' => 25,
];
