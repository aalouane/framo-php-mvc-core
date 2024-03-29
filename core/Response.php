<?php

namespace app\core;

class Response
{

  public function setStatusCode(int $Code)
  {
    http_response_code($Code);
  }

  public function redirect(string $url)
  {
    header("Location: $url");
  }
}
