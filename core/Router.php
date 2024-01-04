<?php

namespace app\core;

/**
 * undocumented class
 */

class Router
{

  public Request $request;
  public Response $response;
  protected array $routes = [];

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback)
  {
    $this->routes["get"][$path] = $callback;
  }

  public function post($path, $callback)
  {
    $this->routes["post"][$path] = $callback;
  }

  public function resolve()
  {
    $path = $this->request->getPath();
    $method = $this->request->getMethod();
    $callback = $this->routes[$method][$path] ?? false;

    if ($callback == false) {
      $this->response->setStatusCode(404);
      return $this->renderView("_404");
    }

    if (is_string($callback)) {
      return $this->renderView($callback);
    }

    if (is_array($callback)) {
      $obj = new $callback[0];
      $method = $callback[1];
      return call_user_func([$obj, $method]);
    }

    return call_user_func($callback);
  }

  public function renderView($view, $params = [])
  {

    $contentLayout = $this->layoutContent();
    $viewContent = $this->renderOnlyView($view, $params);

    return str_replace("{{content}}", $viewContent, $contentLayout);
  }

  protected function layoutContent()
  {

    ob_start();
    include_once  Application::$ROOT_PATH . "/views/layouts/main.php";

    return ob_get_clean();
  }

  protected function renderOnlyView($view, $params = [])
  {
    // create real variables from params
    foreach ($params as $key => $value) {
      $$key = $value;
    }

    ob_start();
    include_once  Application::$ROOT_PATH . "/views/$view.php";

    return ob_get_clean();
  }
}
