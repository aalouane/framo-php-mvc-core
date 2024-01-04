<?php

namespace app\core;

class Controller
{

  public function render($view, $params = array())
  {
    return Application::$app->router->renderView($view, $params);
  }

}
