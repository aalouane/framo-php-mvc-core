<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\Register;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->setLayout('auth');
    
  }

  public function login()
  {
    return $this->render("login");
  }

  public function register()
  {
    return $this->render("register", ["model"=> new Register()]);
  }

  public function registerStore(Request $request)
  {
    $register = new Register();
    $register->loadData($request->getBody());

    if($register->validate() ) {
      return "Successfully registered";
    }

    return $this->render("register", ["model" => $register]);
  }
}
