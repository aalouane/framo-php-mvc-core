<?php

namespace app\core;

/**
 * undocumented class
 */

class Router{

  public Request $request;
  protected array $routes = [];

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  public function get($path, $callback){

    $this->routes["get"][$path] = $callback;
  }

  public function resolve(){

    $path = $this->request->getPath();
    $method = $this->request->getMethod();


    echo $path;
    echo "\n".$method;
  }
}

