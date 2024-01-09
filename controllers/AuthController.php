<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;
use app\models\LoginForm;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->setLayout('auth');
    
  }
  
  public function login()
  {
    return $this->render("login", ["model" => new User()]);
  }

  public function loginStore(Request $request)
  {
    $loginForm = new LoginForm();
    $loginForm->loadData($request->getBody());

    if ($loginForm->validate() && $loginForm->login()) {
      // Application::$app->session->setFlash('success', 'User Login successfully');
      Application::$app->response->redirect("/");
      return;
    }

    return $this->render("register", ["model" => $user]);

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
