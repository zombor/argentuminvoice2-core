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
      $this->_client_validation = new \Argentum\Client\Create\Validation;
    }

    /**
     * @Given /^I am an administrator$/
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
      $this->_client_validation->set_data($this->data);

      $context = new \Argentum\Client\Create($this->_client_repository, $this->_client_validation);

      try
      {
        $this->result = $context->execute($this->data);
      }
      catch (\Argentum\Client\Create\Invalid $e)
      {
        $this->exception = $e;
      }
    }

    /**
     * @Then /^the new client should be created$/
     */
    public function theNewClientShouldBeCreated()
    {
      $client = $this->_client_repository->find_by_email($this->data['email']);
      assertSame($client, $this->data);
    }

    /**
     * @Then /^I should see the following errors:$/
     */
    public function iShouldSeeTheFollowingErrors(PyStringNode $string)
    {
      $expected_errors = explode("\n", $string);
      $errors = [];
      foreach ($this->exception->get_errors() as $key => $error)
        $errors[] = "$key: $error";
      assertSame($errors, $expected_errors);
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
