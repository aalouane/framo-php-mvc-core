<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{

  public function login()
  {
    return $this->render("login");
  }

  public function register()
  {
    $this->setLayout('auth');
    return $this->render("register");
  }

  public function registerStore(Request $request)
  {
    $body = $request->getBody();

    return "Register Handling data";
  }
}
