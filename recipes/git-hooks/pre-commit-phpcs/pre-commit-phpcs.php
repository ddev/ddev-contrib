<?php

/**
 * @file
 * A Git pre-commit script to check files for PHP syntax errors.
 *
 * Requires a properly configured phpcs.xml in your codebase.
 *
 * Inspired from https://www.drupal.org/project/dcq
 * and modified for Drupal 8+ and for running **inside** DDEV.
 */

$exit_code = 0;
$files = [];

// Determine whether this is the first commit or not. If it is, set $against to
// the hash of a magical, empty commit to compare to.
exec('git rev-parse --verify HEAD 2> /dev/null', $files, $return);
$against = ($return == 0) ? 'HEAD' : '4b825dc642cb6eb9a060e54bf8d69288fbee4904';

// Identify changed files.
exec("git diff-index --cached --name-only $against", $files);

print "\nPrecommit PHPCS\n\n";

foreach ($files as $file) {

  if (file_exists($file) && !is_dir($file)) {

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
    $phpcs_cmd = 'phpcs ' . $file;
    $phpcs_output = [];
    exec($phpcs_cmd, $phpcs_output, $return);
    if ($return !== 0) {
      // Format error messages and set exit code.
      echo implode("\n", $phpcs_output), "\n";
      $exit_code = 1;
    }
  }
}

exit($exit_code);
