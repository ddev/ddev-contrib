# Headless Chrome Service

This recipe allows you to configure a Headless Chrome which will be available inside the web container, at `chrome:9222`.

I moved from selenium + Chrome to Headless Chrome because it's faster than Selenium + chrome.

1. Copy [docker-compose.chrome.yaml](docker-compose.chrome.yaml) into your project's .ddev directory.
2. `ddev start`
3. Begin testing. An example scenario is below if you don't have anything set up yet.

An example of how to use this is provided in [behat blog post](https://gorannikolovski.com/blog/drupal-8-and-behat-tests):

* `ddev composer require --dev behat/behat dmore/behat-chrome-extension drupal/drupal-extension bex/behat-screenshot` to install the needed tools if not already in your project.
* Copy the example [behat.yml](behat.yml) provided here into the root of your project (it will be /var/www/html/behat.yml).
* Edit "base_url" under `Drupal\MinkExtension`in the behat.yml
* `ddev ssh -d /var/www/html` to get into the container and work in /var/www/html (which is the root of your project).
* `vendor/bin/behat --init`
* Copy [first-test.feature](first-test.feature) into the features directory that has just been created in the root of your repository.
* `vendor/bin/behat` (inside the container) will test first-feature (which works on a default Drupal 8 profile install)

**Contributed by [isholgueras](https://github.com/isholgueras)**
