<?php

namespace Argentum\Client;

class CreateTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->_client_repository = \Mockery::mock('client_repository');
  }

  public function test_it_saves_client_information_in_the_repository()
  {
    $this->_client_repository->shouldReceive('create')->with(['data'])->andReturn('the client');

    $context = new Create($this->_client_repository);
    $result = $context->execute(['data']);
    $this->assertSame($result, 'the client');
  }
}
