# DrupalCI ChromeDriver

This recipe adds the DrupalCI ChromeDriver container to a project.

Among other things, this support Drupal's FunctionalJavascript tests.
But it also supports Behat with WebDriver or any other use of headless Chrome.
It is based on Matt Glaman's excelent blog post: https://glamanate.com/blog/running-drupals-functionaljavascript-tests-ddev

## Requirements

None

## Configuration

None

## Installation

* Copy `docker-compose.chromedriver.yaml` to the `.ddev` folder of your project.
* Set environment variables as appropriate. Examples are for Drupal Functional and FunctionalJavascript testing.
  * To do this, copy (merge variables if one already exists) `docker-compose.environment.yaml` to the `.ddev` folder of your project.
* Verify your phpunit.xml does not define environment variable for `MINK_DRIVER_ARGS_WEBDRIVER`. These should come from environment variable.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* To test the setup, run a Drupal unit test that triggers ChromeDriver. Example:
```shell script
user@demo-web:/var/www/html$ vendor/bin/phpunit --verbose -c core/phpunit.xml.dist core/modules/system/tests/src/FunctionalJavascript/System/DateFormatTest.php
```

**Contributed by [@mglaman](https://github.com/mglaman)
and [@heddn](https://github.com/heddn)**
