# Chrome Driver

This recipe adds a Chrome Driver container to a project.

This will allow you to have Drupal's Functional Javascript tests, among other things.

## Requirements

None

## Configuration

None

## Installation

* Copy `docker-compose.chromedriver.yaml` to the `.ddev` folder of your project.
* Copy (merge variables if one already exists) `docker-compose.environment.yaml` to the `.ddev` folder of your project.
* Verify you phpunit.xml does not define environment variable for `MINK_DRIVER_ARGS_WEBDRIVER`. These should come from environment variable.
* Start (or restart) DDEV to have the service initialized: `ddev start`

**Contributed by [@mglaman](https://github.com/mglaman)
and [@heddn](https://github.com/heddn)**
