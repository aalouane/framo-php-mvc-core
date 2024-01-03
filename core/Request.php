<?php

namespace app\core;

class Request
{

  public function getPath()
  {
    // http://localhost:8000/contact?id=61
    $path = $_SERVER["REQUEST_URI"] ?? "/";
    $position = strpos($path, "?");

    if ($position === false) {
      return $path;
    }

    return substr($path, 0, $position);
  }


  public function getMethod()
  {
    return strtolower($_SERVER["REQUEST_METHOD"]);
  }
}
