<?php

namespace app\core;

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
  public ?DBModel $user;

  public string $userClass;

  public function __construct(string $rootpath, array $config)
  {
    self::$ROOT_PATH = $rootpath;
    self::$app = $this;

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
    $this->session = new Session();
    $this->db = new Database($config['db']);

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
    echo $this->router->resolve();
  }


  public function login(DBModel $user): bool
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
