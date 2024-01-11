<?php 

namespace app\core;

class View
{

  public string $title;
  // private string $layout = "main";


  public function renderView($view, $params = [])
  {
    
    $viewContent = $this->renderOnlyView($view, $params);
    $contentLayout = $this->layoutContent();

    return str_replace("{{content}}", $viewContent, $contentLayout);
  }

  protected function layoutContent()
  {
    $layout = Application::$app->layout;
    if(Application::$app->controller) {
      $layout = Application::$app->controller->layout;
    }

    ob_start();
    include_once  Application::$ROOT_PATH . "/views/layouts/$layout.php";

    return ob_get_clean();
  }

  protected function renderOnlyView($view, $params = [])
  {
    // create real variables from params names
    foreach ($params as $key => $value) {
      $$key = $value;
    }

    ob_start();
    include_once  Application::$ROOT_PATH . "/views/$view.php";

    return ob_get_clean();
  }

}