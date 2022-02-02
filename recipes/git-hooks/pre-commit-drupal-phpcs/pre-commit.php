<?php

/**
 * @file
 * A Git pre-commit hook script to check files.
 *
 * Checks for PHP syntax errors and Drupal coding standards violations.
 * Requires phpcs and Coder Sniffer.
 *
 * @see https://drupal.org/node/1419988
 *
 * Heavily copied from https://www.drupal.org/project/dcq
 * and modified for Drupal 8+ and for running **inside** DDEV.
 *
 * Ignores all files under config/sync
 */

const CONFIG_ROOT = 'config/sync';

$return_back = '../../';
// Building an array of ignored files and folders.
$file_path = __DIR__ . '/' . $return_back . '.phpcs_ignore';
$ignore = [];
$ignore[] = CONFIG_ROOT;
if (file_exists($file_path)) {
  $file = fopen($file_path, "r");
  if ($file) {
    while (!feof($file)) {
      $ignore[] = fgets($file);
    }
  }
}

// Extensions of files to test.
$file_exts = [
  'php',
  'module',
  'inc',
  'install',
  'profile',
  'test',
  'theme',
  'txt',
  'info',
  'md',
  'yml',
];

$exit_code = 0;
$files = [];
$return = 0;

// Determine whether this is the first commit or not. If it is, set $against to
// the hash of a magical, empty commit to compare to.
exec('git rev-parse --verify HEAD 2> /dev/null', $files, $return);
$against = ($return == 0) ? 'HEAD' : '4b825dc642cb6eb9a060e54bf8d69288fbee4904';

// Identify changed files.
exec("git diff-index --cached --name-only $against", $files);

print "\nPrecommit PHPCS\n\n";

// The number of ignored items.
$ignored_items_count = count($ignore);
echo "\033[0;31mYou have $ignored_items_count item(s) in your ignore list!\n\033[0m";

foreach ($files as $file) {

  if (file_exists($file) && !is_dir($file)) {

    // Check files to ignore.
    if ($ignored_items_count > 0) {
      foreach ($ignore as $key => $value) {
        if (substr($file, 0, strlen(trim($value))) == trim($value) && trim($value) != '') {
          echo "\033[0;31mIgnored in .phpcs_ignore file: $file\n\033[0m";
          continue 2;
        }
      }
    }

    echo "\033[0;32mChecking file {$file}\033[0m\n\n";

    $ext = pathinfo($file, PATHINFO_EXTENSION);

    if (!in_array($ext, $file_exts)) {
      continue;
    }

    $phpcs_output = [];

    $file = escapeshellarg($file);
    // Add extra path to get warranty for run drush.
    $dir = str_replace('\'', '', dirname($file));
    $extra = '';
    if ($dir !== '.') {
      $extra = $dir . '/';
    }

    // Perform PHP syntax check (lint).
    $return = 0;
    $lint_cmd = "php -l {$file}";
    $lint_output = [];
    exec($lint_cmd, $lint_output, $return);
    if ($return !== 0) {
      // Format error messages and set exit code.
      $exit_code = 1;
    }

    // Perform phpcs test.
    $return = 0;
    $phpcs_cmd = 'cd /var/www/html && phpcs --standard=Drupal --extensions=php,module,inc,install,test,profile,theme ' . $file;
    exec($phpcs_cmd, $phpcs_output, $return);
    if ($return !== 0) {
      // Format error messages and set exit code.
      echo implode("\n", $phpcs_output), "\n";
      $exit_code = 1;
    }
  }
}

exit($exit_code);
