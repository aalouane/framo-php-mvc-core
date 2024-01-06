<?php

namespace app\core\Form;

use app\core\Model;

class Field
{

  public Model $model;
  public string $attribute;

  public function __construct(Model $model, string $attribute)
  {
    $this->model = $model;
    $this->attribute = $attribute;

    $this->field();
  }

  public function field()
  {
    echo sprintf(
      '
      <div class="form-group">
        <label>%s</label>
        <input type="%s" class="form-control %s" name="%s" value="%s">
        <div class="invalid-feedback"> %s </div>
      </div>
      ',
      $this->attribute, // label name
      $this->attribute, // type
      $this->model->hasError($this->attribute) ? 'is-invalid' : '', // classes
      $this->attribute, // name 
      $this->model->{$this->attribute}, // value
      $this->model->getError($this->attribute), // error
    );
  }
}
