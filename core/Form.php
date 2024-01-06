<?php

namespace app\core;


class Form
{
  public static function field(Model $model, string $attribute)
  {
    echo sprintf(
      '
      <div class="form-group">
        <label>%s</label>
        <input type="%s" class="form-control %s" name="%s" value="%s">
        <div class="invalid-feedback"> %s </div>
      </div>
      ',
      $attribute, // label name
      $attribute, // type
      $model->hasError($attribute) ? 'is-invalid' : '', // classes
      $attribute, // name 
      $model->{$attribute}, // value
      $model->getError($attribute), // error
    );
  }
}
