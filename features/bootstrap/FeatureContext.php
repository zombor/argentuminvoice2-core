<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
      $this->_client_repository = new Client_Repository_Memory;
    }

    /**
     * @Given /^I am an administraor$/
     */
    public function iAmAnAdministraor()
    {
    }

    /**
     * @When /^I create a client with the following properties:$/
     */
    public function iCreateAClientWithTheFollowingProperties(TableNode $table)
    {
      $this->data = current($table->getHash());

      $context = new \Argentum\Client\Create($this->_client_repository);
      $this->result = $context->execute($this->data);
    }

    /**
     * @Then /^the new client should be created$/
     */
    public function theNewClientShouldBeCreated()
    {
      $client = $this->_client_repository->find_by_email($this->data['email']);
      assertSame($client, $this->data);
    }

}

class Client_Repository_Memory
{
  protected $_clients = [];

  public function create($data)
  {
    $this->_clients[] = $data;
    return $data;
  }

  public function find_by_email($email)
  {
    foreach ($this->_clients as $client)
    {
      if ($client['email'] == $email)
        return $client;
    }
  }
}
