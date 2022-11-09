# Setup Behat for Drupal 8/9 with  DDEV-Local and Selenium

**Note: You may want to take a look at the [ddev-selenium-standalone-chrome add-on](https://github.com/weitzman/ddev-selenium-standalone-chrome) for this situation.**

1. Add the [Behat Drupal Extension](https://github.com/jhedstrom/drupalextension) to your project using Composer: `ddev composer require drupal/drupal-extension='~4.0'`
` (see [youtube video](https://www.youtube.com/watch?v=KRqqKZPBqpA)) This installs Behat and other required dependencies.

2. Add a Selenium container in your project. Copy [docker-compose.selenium.yml](docker-compose.selenium.yaml) to your project's .ddev folder (see [original source Stack Overflow answer](https://stackoverflow.com/questions/51527663/running-selenium-tests-using-drupalextension-inside-ddev-docker-containers))

3. Copy [behat.yml](behat.yml) to your project root.

4. Update `base_url` in behat.yml with your project's URL.

5. Initialize Behat with `ddev exec -d /var/www/html behat --init` - This will create a `features` folder in your project root.

6. Example test: Copy [account_registration.feature](account_registration.feature) to the `features` directory of your project. (See [youtube demonstration](https://www.youtube.com/watch?v=KRqqKZPBqpA).)

7. Run a simple test with `ddev exec -d /var/www/html behat` or

```bash
ddev ssh -d /var/www/html
behat
```

You should see results similar to this:

```text

Feature: Account Registration
  In order to create an account
  As a user
  I need to be able to complete the registration form

  Scenario: Complete the registration form    # features/account_registration.feature:8
    Given I am on "/user/register"            # Drupal\DrupalExtension\Context\MinkContext::visit()
    And I enter "t@gmail.com" for "edit-mail" # Drupal\DrupalExtension\Context\MinkContext::assertEnterField()
    And I enter "tom" for "edit-name"         # Drupal\DrupalExtension\Context\MinkContext::assertEnterField()
    And I press the "edit-submit" button      # Drupal\DrupalExtension\Context\MinkContext::pressButton()

1 scenario (1 passed)
4 steps (4 passed)
0m0.56s (5.59Mb)
```

**Contributed by [@erubino1977](https://github.com/erubino1977)**
