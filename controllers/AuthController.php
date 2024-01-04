<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Register;

class AuthController extends Controller
{

  public function login()
  {
    $this->setLayout('auth');
    return $this->render("login");
  }

  public function register()
  {
    $this->setLayout('auth');
    return $this->render("register");
  }

  public function registerStore(Request $request)
  {
    $register = new Register();
    $body = $request->getBody();

    return "Register Handling data";
  }
}
