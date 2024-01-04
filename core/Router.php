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
  private string $layout = "main";

  public function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  public function setLayout($layout)
  {
    return $this->layout = $layout;
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
    $method = $this->request->method();
    $callback = $this->routes[$method][$path] ?? false;

    if ($callback == false) {
      $this->response->setStatusCode(404);
      return $this->renderView("_404");
    }

    if (is_string($callback)) {
      return $this->renderView($callback);
    }

    if (is_array($callback)) {
      // for call_user_func()
      $callback[0] = new $callback[0]();
    }

    return call_user_func($callback, $this->request);
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
    include_once  Application::$ROOT_PATH . "/views/layouts/$this->layout.php";

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
