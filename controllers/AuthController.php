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
    $register = new Register();
    $this->setLayout('auth');

    return $this->render("register", ["model"=>$register]);
  }

  public function registerStore(Request $request)
  {
    $register = new Register();
    $register->loadData($request->getBody());

    if($register->validate() ) {
      return "Successfully registered";
    }

    var_dd($register->errors);
    $body = $request->getBody();

    return "Register Handling data";
  }
}
