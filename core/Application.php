<?php

namespace app\core;


/**
 * undocumented class
 */

class Application
{

  public static $ROOT_PATH;
  public static Application $app;
  public Request $request;
  public Router $router;
  public Response $response;
  public Database $db;

  public function __construct(string $rootpath, array $config)
  {
    self::$ROOT_PATH = $rootpath;
    self::$app = $this;

    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);

    $this->db = new Database($config['db']);
  }

  public function run()
  {
    echo $this->router->resolve();
  }
}
