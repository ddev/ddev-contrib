# DrupalCI ChromeDriver (Behat, DrupalCI, FunctionalJavascript)

**Note: You may want to take a look at the [ddev-selenium-standalone-chrome add-on](https://github.com/weitzman/ddev-selenium-standalone-chrome) for this situation.**

This recipe adds the DrupalCI ChromeDriver container to a project.

**Note that the drupalci Chromedriver does not work on macOS M1 computers.**

Among other things, this supports Drupal's FunctionalJavascript tests.
But it also supports Behat with WebDriver or any other use of headless Chrome.
It is based on [Matt Glaman's excelent blog post](https://glamanate.com/blog/running-drupals-functionaljavascript-tests-ddev)

## Installation

* Copy `docker-compose.chromedriver.yaml` to the `.ddev` folder of your project.
* Set environment variables in the "environment" section of the "web" service in `docker-compose.chromedriver.yaml` as appropriate. The defaults are for Drupal Functional and FunctionalJavascript testing.
* Verify that your phpunit.xml does not define `MINK_DRIVER_ARGS_WEBDRIVER`, `SIMPLETEST_DB`, `SIMPLETEST_BASE_URL`, `BROWSERTEST_OUTPUT_DIRECTORY`, or `BROWSERTEST_OUTPUT_BASE_URL`. These should come from our docker-compose.chromedriver.yaml.
* Ensure that one of the two `SIMPLETEST_DB` options is uncommented.
* Start (or restart) DDEV to have the service initialized: `ddev start`
* Your Drupal project must be built with --require-dev to get necessary dependencies like phpunit (for example, `ddev composer create drupal/recommended-project --require-dev`)
* To test the setup, `ddev ssh` and run a Drupal unit test that triggers ChromeDriver. Example (assumes Drupal core is in the `web` directory):

```bash
user@demo-web:/var/www/html$ phpunit -c web/core/phpunit.xml.dist web/core/modules/system/tests/src/FunctionalJavascript/System/DateFormatTest.php
```
## Example run

From @damienmckenna, here's an example run to demonstrate functionality:

```bash
$ ddev exec phpunit -c core/phpunit.xml.dist core/modules/system/tests/src/FunctionalJavascript/System/DateFormatTest.php
PHPUnit 8.5.8 by Sebastian Bergmann and contributors.

Runtime:       PHP 7.3.27-9+0~20210227.82+debian10~1.gbpa4a3d6
Configuration: /var/www/html/core/phpunit.xml.dist

Testing Drupal\Tests\system\FunctionalJavascript\System\DateFormatTest
.                                                                   1 / 1 (100%)

Time: 53.15 seconds, Memory: 4.00 MB

OK (1 test, 6 assertions)

HTML output was generated
https://d91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-13-97496575.html
https://d91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-14-97496575.html
https://d91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-15-97496575.html
https://d91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-16-97496575.html
https://d91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-17-97496575.html
```

## Notes

* There is no need to modify the phpunit.xml.dist file, core's included file can be referenced as-is, per the example above.
* In order for this to work all other ddev instances must be turned off, only the Drupal core instance which will be used for the PHPUnit tests can be running.
* Do not modify the `SIMPLETEST_BASE_URL`, otherwise ChromeDriver will not be able to access the test site.

## Possible problems and potential solutions

* If the tests return the error message "unable to set cookie" it is likely that the `SIMPLETEST_BASE_URL` value was modified from its original value of `http://web`. Changing it back to `http://web` should resolve this problem.
* If the sample core test fails, load the output HTML files mentioned at the end of the output, e.g. `https://drupalcore91.ddev.site/sites/simpletest/browser_output/Drupal_Tests_system_FunctionalJavascript_System_DateFormatTest-9-12332112.html`, and see what the output contains, that may help track down the source of the problem.
* If the output of the sample test contains HTML from a different website, check to see if other ddev instances or Docker images are running, and shut them down if needed.

**Contributed by [@mglaman](https://github.com/mglaman)
and [@heddn](https://github.com/heddn)**
