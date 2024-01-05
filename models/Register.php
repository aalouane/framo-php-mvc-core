<?php

namespace app\models;

use app\core\Model;

class Register extends Model
{
  protected string $firstname;
  protected string $lastname;
  protected string $email;
  protected string $password;
  protected string $confirmPassword;

  public function rules() : array
  {
    return [
      'firstname' => [self::RULE_REQUIRED],
      'lastname' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min'=>4],[self::RULE_MAX, 'max' => 24]],
      'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match'=>'password']]
    ];
  }

  
}
