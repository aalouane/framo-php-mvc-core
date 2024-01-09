<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\models\User;


class LoginForm extends Model
{

  public string $email = '';
  public string $password = '';

  // public static function tableName(): string
  // {
  //   return "users";
  // }

  // public function attributes(): array
  // {
  //   return ["email", "password"];
  // }

  public function rules(): array
  {
    return [
      'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
      'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4], [self::RULE_MAX, 'max' => 24]],
    ];
  }

  public function login()
  {
    $user = User::findOne(["email" => $this->email]);

    // Verify the email
    if (!$user) {
      $this->addError("email", "User does not exist");
      return false;
    }
    
    // Verify the password
    if(!password_verify($this->password, $user->password)) {
      $this->addError("password", "Password incorrect");
      return false;
    }
    echo "hh";
    
    return Application::$app->login($user);
  }
}
