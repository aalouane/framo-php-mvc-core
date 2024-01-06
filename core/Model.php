<?php

namespace app\core;

abstract class Model
{
  public const RULE_REQUIRED = 'required';
  public const RULE_EMAIL = 'email';
  public const RULE_MIN = 'min';
  public const RULE_MAX = 'max';
  public const RULE_MATCH = 'match';

  public array $errors = [];

  abstract public function rules(): array;

  public function loadData($data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->{$key} = $value;
      }
    }
  }

  public function validate()
  {
    // rules should defined in the subclass 
    $rules = $this->rules(); // rules = ['firstname' => [self::RULE_REQUIRED],]
    foreach ($rules as $modelField => $rules) {
      $value = $this->{$modelField}; // value = $register->firstname

      foreach ($rules as $rule) {
        $ruleName = $rule; // ruleName = [self::RULE_REQUIRED] | [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]

        if (is_array($rule)) {
          $ruleName = $ruleName[0]; // self::RULE_REQUIRED]
        }

        // Check rules for model fields
        if ($ruleName === self::RULE_REQUIRED && !$value) {
          $this->addError($modelField, self::RULE_REQUIRED);
        }
        if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
          $this->addError($modelField, self::RULE_EMAIL);
        }
        if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
          $this->addError($modelField, self::RULE_MIN, $rule);
        }
        if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
          $this->addError($modelField, self::RULE_MAX, $rule);
        }
        // {$rule['match']} = password
        if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
          $this->addError($modelField, self::RULE_MATCH, $rule);
        }
      }
    }

    return empty($this->errors);
  }

  public function addError(string $modelField, string $rule, array $params = [])
  {
    $message = $this->errorMessage()[$rule] ?? '';
    foreach ($params as $key => $value) {
      $message = str_replace("{{$key}}", $value, $message);
    }

    $this->errors[$modelField][] = $message;
  }

  public function errorMessage()
  {
    return [
      self::RULE_REQUIRED => "This fields is required",
      self::RULE_EMAIL    => "This field is must be a valid email address",
      self::RULE_MIN      => "The min length of this field must be {min}",
      self::RULE_MAX      => "The max length of this field must be {max}",
      self::RULE_MATCH    => "The fields must be the same as {match}",
    ];
  }

  // replace this two methods(hasError, getError) with just one
  public function hasError($attribute)
  {
    return $this->errors[$attribute] ?? false;
  }
  
  public function getError($attribute)
  {
    return $this->errors[$attribute][0] ?? false;
  }
}