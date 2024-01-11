<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use \PDO;

abstract class DbModel extends Model
{

  abstract public static function tableName(): string;
  
  abstract public function attributes(): array;

  abstract public static function primaryKey(): string;

  public function save()
  {
    $tableName = static::tableName();
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

  public static function findOne(array $where)  // ["email" => "soufiane@gmail.com"] | ["username" => "soufiane"]
  {
    // static here replace the name class where is this method called
    $table = static::tableName();
    $attributes = array_keys($where);

    // "SELECT * FROM $table WHERE email = :email AND username = :username"
    $sql = "SELECT * FROM $table WHERE ";
    $whereRequest = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
    $sql .= $whereRequest;
    $statement = self::prepare($sql);
    
    // Bind Values
    foreach ($where as $key => $item) {
      $statement->bindValue(":$key", $item);
    }

    $statement->execute();
    return $statement->fetchObject(static::class); // return an instance of the class(model) calling this method
  } 

  public static function prepare($sql) {
    
    return Application::$app->db->pdo->prepare($sql);
  }

}
