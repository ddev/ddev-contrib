# This example feature should be placed in the project's "features" directory.

Feature: Account Registration
In order to create an account
As a user
I need to be able to complete the registration form

Scenario: Complete the registration form
    Given I am on "/user/register"
    And I enter "t@gmail.com" for "edit-mail"
    And I check the box "edit-contact--2"
    And I press the "edit-submit" button
