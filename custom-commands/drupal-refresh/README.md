# Refresh your local Drupal environment in one command

This command refreshes your local Drupal environment, including steps to:
- fetch the latest code
- download and import a database
- compile front-end assets
- composer install
- execute Drupal database updates
- rebuild caches
- and other stuff

It currently relies on [Drainpipe](https://github.com/Lullabot/drainpipe/) for
some functionality, but you may replace the `task` commands with your own steps.
E.g.,
[these steps](https://architecture.lullabot.com/adr/20210924-drupal-build-steps)
for building Drupal.

You may pass a branch name, and `refresh` will switch to that branch before
running the steps. This is useful e.g. to give other developers a one-line
command to set up your feature in their local environment for testing and code
review.

To use, place the `refresh` script in your project's `.ddev/commands/host`
folder.

If you don't need `refresh` to run _all_ the steps, you can pass various flags
to turn behavior on and off. Detailed usage:

```
$ ddev refresh -h

Refreshes the local development environment.

Usage:
ddev refresh [branch] [flags]

Examples:
"ddev refresh some-branch --no-restart --import-db"

Flags:
-e, --existing-sql   Import the existing/previously-downloaded database dump rather than downloading a new one.
-h, --help           help for refresh
-i, --import-db      Import a Drupal database dump (downloads a fresh copy unless the "--existing-sql" flag is given).
-A, --no-assets      Don't compile front-end assets (JS, CSS, etc).
-C, --no-composer    Don't run "composer install".
-G, --no-git-pull    Don't update the git branch.
-L, --no-login       Don't open a browser in a one-time login URL.
-R, --no-restart     Don't restart ddev, e.g., because you know there have been no ddev configuration changes.
-U, --no-update      Don't run Drupal database updates, import configuration, or clear caches, etc.
-v, --verbose        Show more command output.
-y, --yes            Automaticallly answer "yes" to all confirmation prompts.
```

**Contributed by [Hawkeye Tenderwolf](https://github.com/hawkeyetwolf)**
