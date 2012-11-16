<?php

namespace Argentum\Client;

class Create
{
  public function __construct($client_repository)
  {
    $this->_client_repository = $client_repository;
  }

  public function execute($client_data)
  {
    $client = $this->_client_repository->create($client_data);
    return $client;
  }
}
