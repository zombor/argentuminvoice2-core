<?php

namespace Argentum\Client\Create;

class ValidationTest extends \PHPUnit_Framework_TestCase
{
  public function test_it_sets_data()
  {
    $data = [
      'name' => 'foobar',
      'email' => 'foo@bar.com',
    ];

    $validation = new Validation;
    $validation->set_data($data);
  }

  public function test_it_passes_valid_data()
  {
    $data = [
      'name' => 'foobar',
      'email' => 'foo@bar.com',
    ];

    $validation = new Validation($data);

    $this->assertTrue($validation->valid());
  }

  public function test_it_requires_name_and_email_keys()
  {
    $validation = new Validation([]);

    $this->assertFalse($validation->valid());
    $this->assertSame(
      [
        'name' => 'required',
        'email' => 'required',
      ],
      $validation->errors()
    );
  }

  public function test_it_requires_name_and_email_values()
  {
    $validation = new Validation(['name' => '', 'email' => '']);

    $this->assertFalse($validation->valid());
    $this->assertSame(
      [
        'name' => 'required',
        'email' => 'required',
      ],
      $validation->errors()
    );
  }

  public function valid_email_provider()
  {
    return [
      ['foo'],
      ['foo@bar'],
      ['foo.com'],
      ['foo@.com'],
    ];
  }

  /**
   * @dataProvider valid_email_provider
   */
  public function test_it_requires_valid_email($email)
  {
    $validation = new Validation(['name' => 'foo', 'email' => $email]);
    $this->assertFalse($validation->valid());
    $this->assertSame(
      [
        'email' => 'email',
      ],
      $validation->errors()
    );
  }
}
