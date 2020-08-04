# Setup Behat for Drupal 8 with  DDEV-Local and Selenium

1. Add the [Behat Drupal Extension](https://www.drupal.org/project/drupalextension) to your project using Composer: `ddev composer require –dev drupal/drupal-extension` (see [youtube video](https://www.youtube.com/watch?v=KRqqKZPBqpA)) This installs Behat and other required dependencies.

2. Add a Selenium container in your project. Copy [docker-compose.selenium.yml](docker-compose.selenium.yaml) to your project's .ddev folder (see [original source Stack Overflow answer](https://stackoverflow.com/questions/51527663/running-selenium-tests-using-drupalextension-inside-ddev-docker-containers))

3. Copy [behat.yml](behat.yml) to your project root and update base_url to be specific to your project.

4. Initialize Behat:

   * `ddev ssh -d /var/www/html`
   * `behat --init`
   
   This will create a `features` folder in your project root 

5. Example test: Copy [account_registration.feature](account_registration.feature) to the `features` directory of your project. (See [youtube demonstration](https://www.youtube.com/watch?v=KRqqKZPBqpA).)

6. Run a simple test:
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

   Scenario: Complete the registration form    # features/account_registration.feature:6
        Given I am on "/user/register"            # Drupal\DrupalExtension\Context\MinkContext::visit()
        And I enter "t@gmail.com" for "edit-mail" # Drupal\DrupalExtension\Context\MinkContext::assertEnterField()
        And I check the box "edit-contact--2"     # Drupal\DrupalExtension\Context\MinkContext::assertCheckBox()
        And I press the "edit-submit" button      # Drupal\DrupalExtension\Context\MinkContext::pressButton()

    1 scenario (1 passed)
    4 steps (4 passed)
    0m21.80s (5.92Mb)
```

**Contributed by [@erubino1977](https://github.com/erubino1977)**
