<?php

namespace app\core;

use app\core\Application;
use \PDO;

abstract class DBModel extends Model
{

  abstract public function tableName(): string;
  
  abstract public function attributes(): array;

  public function save()
  {
    $tableName = $this->tableName();
    $attributes = $this->attributes();
    $params = implode(',',array_map(fn($attr)=>":".$attr, $attributes));
    $fields = implode(',', $attributes);
    
    $sql = "INSERT INTO " . $tableName . " (" . $fields. ") VALUES (" . $params.")";
    $statement = self::prepare($sql);

    // bindValue: replace params with values from models(User, ....)
    foreach ($attributes as $attribute) {
      $statement->bindValue(":$attribute", $this->{$attribute}); // $this called on model User ....
    }

    $statement->execute();

    return true;
  }

  public static function getValues(string $table, string $field, string $value)
  {
    $sql = "SELECT $field FROM $table WHERE $field = :value";
    
    $statement = Application::$app->db->pdo->prepare($sql);
    $statement->bindValue(":value", $value);
    $statement->execute();

    return $statement->fetchObject();
  }

  public static function prepare($sql) {
    
    return Application::$app->db->pdo->prepare($sql);
  }

}
