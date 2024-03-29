<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{

  public string $action = '';
  protected array $middlewares = []; // array of BaseMiddlewares
  public string $layout = "main";  // it can be changed on childs 

  public function render($view, $params = array())
  {
    return Application::$app->view->renderView($view, $params);
  }

  public function setLayout($layout)
  {
    return Application::$app->router->setLayout($layout);
  }

  public function registerMiddleware(BaseMiddleware $middleware)
  {
    $this->middlewares[] = $middleware;
  }

  public function getMiddlewares(): array
  {
    return $this->middlewares;
  }
}
