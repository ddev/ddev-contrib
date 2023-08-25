# Headless Chrome Service

**Note: You may want to take a look at the [ddev-selenium-standalone-chrome add-on](https://github.com/ddev/ddev-selenium-standalone-chrome) for this situation.**

This recipe allows you to configure a Headless Chrome which will be available inside the web container, at `chrome:9222`.

I moved from selenium + Chrome to Headless Chrome because it's faster than Selenium + chrome.

1. Copy [docker-compose.chrome.yaml](docker-compose.chrome.yaml) into your project's .ddev directory.
2. `ddev start`
3. Begin testing. An example scenario is below if you don't have anything set up yet.

An example of how to use this is provided in [behat blog post](https://gorannikolovski.com/blog/drupal-8-and-behat-tests):

* `ddev composer require --dev behat/behat dmore/behat-chrome-extension drupal/drupal-extension bex/behat-screenshot` to install the needed tools if not already in your project.
* Copy the example [behat.yml](behat.yml) provided here into the root of your project (it will be /var/www/html/behat.yml inside the container).
* Edit "base_url" under `Drupal\MinkExtension`in the behat.yml. Use the `http` URL for your project rather than `https` because the chrome container does not trust the mkcert certificate used in the web container.
* `ddev ssh` to get into the container and work in `/var/www/html` (which is the root of your project).
* `vendor/bin/behat --init`
* Copy [first-test.feature](first-test.feature) into the features directory that has just been created in the root of your repository.
* `behat` (inside the container) or `ddev exec behat` on the host will test first-feature (which works on a default Drupal 9 profile install)

**Contributed by [isholgueras](https://github.com/isholgueras)**
