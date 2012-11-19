<?php

namespace Argentum\Client;

class Create
{
  public function __construct($client_repository, Create\Validation $validator)
  {
    $this->_client_repository = $client_repository;
    $this->_validator = $validator;
  }

  public function execute($client_data)
  {
    $this->_validator->set_data($client_data);

    if ( ! $this->_validator->valid())
      throw new Create\Invalid;

    $client = $this->_client_repository->create($client_data);
    return $client;
  }
}
