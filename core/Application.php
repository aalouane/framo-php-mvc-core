<?php

namespace app\core;

use app\core\db\Database;

/**
 * undocumented class
 */

class Application
{

  public static $ROOT_PATH;
  public static Application $app;

  public Controller $controller;
  public Request $request;
  public Router $router;
  public Response $response;
  public Session $session;
  public Database $db;
  public ?UserModel $user;
  public View $view;

  public string $userClass;
  public string $layout = "main";
  
  public function __construct(string $rootpath, array $config)
  {
    self::$ROOT_PATH = $rootpath;
    self::$app = $this;

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
    $this->session = new Session();
    $this->db = new Database($config['db']);
    $this->view = new View();

    // Get user information from session if available
    $this->userClass = $config['userClass'];
    $primaryValue = $this->session->get('user');
    if($primaryValue) {
      $primaryKey = $this->userClass::primaryKey();
      $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
    } else {
      $this->user = null;
    }
  }

  public static function isGuest(): bool
  {
    return !self::$app->user;
  }

  public function run(): void
  {
    try { 
      echo $this->router->resolve();
    }catch (\Exception $e) {
      $this->response->setStatusCode($e->getCode());
      echo $this->view->renderView("_error", ["exceptions" => $e]);
    }
  }


  public function login(UserModel $user): bool
  {
    $this->user = $user;
    $primaryKey = $user->primaryKey();
    $primaryValue = $user->{$primaryKey};
    Application::$app->session->set('user', $primaryValue);

    return true;
  }

  public function logout(): void
  {
    $this->user = null;
    $this->session->remove("user");
  }
}
