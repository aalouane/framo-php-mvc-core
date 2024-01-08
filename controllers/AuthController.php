<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

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
    return $this->render("register", ["model"=> new User()]);
  }

  public function registerStore(Request $request)
  {
    $user = new User();
    $user->loadData($request->getBody());


    if($user->validate() && $user->save()) {
      Application::$app->session->setFlash('success', 'User registered successfully');
      Application::$app->response->redirect("/");
    }

    return $this->render("register", ["model" => $user]);
  }
}
