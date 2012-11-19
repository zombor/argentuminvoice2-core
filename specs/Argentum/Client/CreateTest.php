<?php

namespace Argentum\Client;

class CreateTest extends \PHPUnit_Framework_TestCase
{
  protected function setUp()
  {
    $this->_client_repository = \Mockery::mock('client_repository');
    $this->_validator = \Mockery::mock('Argentum\Client\Create\Validation');
  }

  public function test_it_saves_client_information_in_the_repository()
  {
    $data = ['name' => 'foobar', 'email' => 'foo@bar.com'];
    $this->_client_repository->shouldReceive('create')->with($data)->andReturn('the client');

    $this->_validator->shouldReceive('set_data')->once()->with($data);
    $this->_validator->shouldReceive('valid')->once()->andReturn(TRUE);

    $context = new Create($this->_client_repository, $this->_validator);
    $result = $context->execute($data);
    $this->assertSame($result, 'the client');
  }

  public function test_it_throws_exception_on_invalid_data()
  {
    $data = [];

    $this->_validator->shouldReceive('set_data')->once()->with($data);
    $this->_validator->shouldReceive('valid')->once()->andReturn(FALSE);

    $context = new Create($this->_client_repository, $this->_validator);

    $this->setExpectedException('Argentum\Client\Create\Invalid');

    $context->execute($data);
  }
}
