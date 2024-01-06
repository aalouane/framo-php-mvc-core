<?php

namespace app\core;


class Form
{

  public static function text(Model $model, string $attr, string $label='', string $prefix_id = '')
  {
    Form::field($model, $attr, 'text', $label, $prefix_id);
  }

  public static function email(Model $model, string $attr, string $label='', string $prefix_id = '')
  {
    Form::field($model, $attr, 'email', $label, $prefix_id);
  }

  public static function password(Model $model, string $attr,string $label='', string $prefix_id = '')
  {
    Form::field($model, $attr, 'password', $label, $prefix_id);
  }

  public static function field(Model $model, string $attr, string $type,string $label='', string $prefix_id='')
  {
    // $attr = strtolower(str_replace(" ", "_", $attr));
    $id = $prefix_id.$attr;
    echo sprintf(
      '
      <div class="form-group mb-3">
        <label for="%s">%s</label>
        <input type="%s" id="%s" class="form-control %s" name="%s" value="%s">
        <div class="invalid-feedback"> %s </div>
      </div>
      ',
      $id, // for
      empty($label) ? ucfirst($attr) : $label, // label name
      $type, // type
      $id, // id
      $model->hasError($attr) ? 'is-invalid' : '', // classes
      $attr, // name 
      $model->{$attr}, // value
      $model->getError($attr), // error
    );
  }
}
