# DrupalCI ChromeDriver

This recipe adds the DrupalCI ChromeDriver container to a project.

Among other things, this support Drupal's FunctionalJavascript tests.
But it also supports Behat with WebDriver or any other use of headless Chrome.
It is based on [Matt Glaman's excelent blog post](https://glamanate.com/blog/running-drupals-functionaljavascript-tests-ddev)

## Installation

* Copy `docker-compose.chromedriver.yaml` to the `.ddev` folder of your project.
* Set environment variables in the "environment" section of the "web" service in `docker-compose.chromedriver.yaml` as appropriate. The defaults are for Drupal Functional and FunctionalJavascript testing.
* Verify that your phpunit.xml does not define  `MINK_DRIVER_ARGS_WEBDRIVER`. This should come from our docker-compose.chromedriver.yaml.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* Your Drupal project must be built with --require-dev to get necessary dependencies like phpunit (for example, `ddev composer create drupal/recommended-project --require-dev`)
* To test the setup, `ddev ssh` and run a Drupal unit test that triggers ChromeDriver. Example:

```bash
user@demo-web:/var/www/html$ phpunit --verbose -c web/core/phpunit.xml.dist web/core/modules/system/tests/src/FunctionalJavascript/System/DateFormatTest.php
```

**Contributed by [@mglaman](https://github.com/mglaman)
and [@heddn](https://github.com/heddn)**
