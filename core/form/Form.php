<?php

//  old implementation
namespace app\core\Form;

use app\core\Model;
use app\core\form\Field;

class Form
{
  public static function begin(string $action, string $method): Form
  {
    echo sprintf("<form action='%s' method='%s'>" ,$action, $method);
    return new Form();
  }

  public static function end()
  {
    echo "</form>";
  }

  public function field(Model $model, string $attribute)
  {
    return new Field($model, $attribute);
  }

}