# Setup Behat for Drupal 8 with Docker Desktop + DDEV + Environment

Current Local Versions of Software
•	Windows 10 Pro build 2004 w/ WSL 2
•	Docker Desktop 2.3.0.3 (45519)
•	DDEV version 1.14.2
•	Drupal 8.8.6

Step 1. 
    CD into your project root and install Drupal Extension through Composer “ddev composer require –dev drupal/drupal-extension: (see https://www.youtube.com/watch?v=KRqqKZPBqpA) This installs Behat and all the dependencies

Step 2. 
    Setup a Selenium container in your project. In the .ddev folder create docker-compose.selenium.yml (see https://stackoverflow.com/questions/51527663/running-selenium-tests-using-drupalextension-inside-ddev-docker-containers)
    Then add the following to create docker-compose.selenium.yml
    version: '3.6'
    services:
    selenium:
        container_name: ddev-${DDEV_SITENAME}-selenium
        image: selenium/standalone-chrome-debug:3.13.0-argon
        networks:
        default:
            aliases:
            - web

Step 3. 
    Create aliases using the default network to reference web container running Drupal. In the .ddev folder create docker-compose.override.yml (see https://stackoverflow.com/questions/51527663/running-selenium-tests-using-drupalextension-inside-ddev-docker-containers) 
    Then add the following to create docker-compose.override.yml
    version: '3.6'
    services:
    web:
        depends_on:
        - selenium
    links:
        - selenium:selenium

Step 4. 
    Create behat.yml in the project root and add the following code: Make sure to update base_url to be specific to your project
    default:
    suites:
        default:
        contexts:
            - FeatureContext
            - Drupal\DrupalExtension\Context\DrupalContext
            - Drupal\DrupalExtension\Context\MinkContext
            - Drupal\DrupalExtension\Context\MessageContext
            - Drupal\DrupalExtension\Context\DrushContext
    extensions:
        "Behat\\MinkExtension":
        goutte: null
        base_url: 'https://drupal.ddev.site'
        javascript_session: selenium2
        selenium2:
            browser: "chrome"
            wd_host: http://selenium:4444/wd/hub
            capabilities:
            extra_capabilities:
                idle-timeout: 50
        Drupal\DrupalExtension:
        blackbox: ~

Step 5. 
    Initialize Behat by through SSH. Run the following command
    ddev ssh to access ssh
    then back out of your web root with cd ../
    finally initialize Behat with the following command
    vendor/bin/behat –init
    This will create a features folder in your project root 

Step 6. 
    Create a feature in “projectroot/features/” named account_registration.feature (this is your test see https://www.youtube.com/watch?v=KRqqKZPBqpA) 
    Add the following code to account_registration.feature

    Feature: Account Registration
    In order to create an account
    As a user
    I need to be able to complete the registration form

    Scenario: Complete the registration form
        Given I am on "/user/register"
        And I enter "t@gmail.com" for "edit-mail"
        And I check the box "edit-contact--2"
        And I press the "edit-submit" button

Step 7. 
    Test behat ddev ssh and then back out 1 directory so you are next to your webroot (/var/www/html/) then run the following command
    vendor/bin/behat
    Example Results: 
    You should see results similar to below
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




