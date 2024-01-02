<?php 

namespace app\core;


/**
 * undocumented class
 */

class Application{

  public static $ROOT_PATH;
  public Request $request;
  public Router $router;

  public function __construct($rootpath){

    $this::$ROOT_PATH = $rootpath;
    $this->request = new Request();
    $this->router = new Router($this->request);
  }

  public function run(){

    echo $this->router->resolve();
  }

}