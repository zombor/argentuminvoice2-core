<?php

namespace Argentum\Client\Create;

class Invalid extends \Exception
{
  protected $_errors = [];

  public function __construct(array $errors)
  {
    $this->_errors = $errors;
  }

  public function get_errors()
  {
    return $this->_errors;
  }
}
