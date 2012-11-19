<?php

namespace Argentum\Client\Create;

class Validation
{
  protected $_data = [];
  protected $_errors = [];

  public function __construct($data = [])
  {
    $this->_data = $data;
  }

  public function set_data(array $data)
  {
    $this->_data = $data;
  }

  public function valid()
  {
    $this->_validate();

    return empty($this->_errors);
  }

  public function errors()
  {
    return $this->_errors;
  }

  protected function _validate()
  {
    if ( ! isset($this->_data['name']) OR empty($this->_data['name']))
      $this->_errors['name'] = 'required';
    if ( ! isset($this->_data['email']) OR empty($this->_data['name']))
      $this->_errors['email'] = 'required';
    else if ( isset($this->_data['email']) AND ! preg_match("/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})$/iD", $this->_data['email']))
      $this->_errors['email'] = 'email';
  }
}


