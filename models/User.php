<?php

namespace app\models;

use app\core\db\DbModel;

class User extends DbModel
{
  public const STATUS_INACTIVE = 0;
  public const STATUS_ACTIVE = 1;
  public const STATUS_DELETED = 2;

  public string $firstname = '';
  public string $lastname = '';
  public string $email = '';
  public int    $status = self::STATUS_INACTIVE;
  public string $password = '';
  public string $confirmPassword = '';


  public static function tableName(): string
  {
    return "users";
  }

  public function attributes(): array
  {
    return ["firstname", "lastname", "email", "status", "password"];  
  }

  public static function primaryKey(): string
  {
    return "id";
  }
  
  // from abstract class UserModel
  public function getUsername(): string
  {
    return $this->firstname;
  }

  public function save()
  {
    $this->status = self::STATUS_INACTIVE;
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    return parent::save();
  }

  public function rules(): array
  {
    return [
      'firstname' => [self::RULE_REQUIRED],
      'lastname' => [self::RULE_REQUIRED],
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, self::RULE_UNIQUE],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]],
      'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
    ];
  }

}
