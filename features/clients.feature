Feature: Client Management
  In order to assign work to clients
  As an administrator
  I need to be able to manage client records

  Scenario: Create a new client
    Given I am an administraor
    When I create a client with the following properties:
      | name        | email               |
      | Test Client | testing@example.com |
    Then the new client should be created
