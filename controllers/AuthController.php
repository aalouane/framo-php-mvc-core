<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\LoginForm;

class AuthController extends Controller
{

  public function __construct()
  {
    $this->middlewares[] = ["profile"];

    $this->setLayout('auth');
  }

  public function login()
  {
    $loginForm = new LoginForm();
    return $this->render("login", ["model" => $loginForm]);
  }

  public function loginStore(Request $request, Response $response)
  {
    $loginForm = new LoginForm();
    $loginForm->loadData($request->getBody());

    if ($loginForm->validate() && $loginForm->login()) {
      $response->redirect("/");
      return;
    }

    return $this->render("login", ["model" => $loginForm]);
  }

  public function register()
  {
    return $this->render("register", ["model" => new User()]);
  }

  public function registerStore(Request $request)
  {
    $user = new User();
    $user->loadData($request->getBody());


    if ($user->validate() && $user->save()) {
      Application::$app->session->setFlash('success', 'User registered successfully');
      $response->redirect("/");
    }

    return $this->render("register", ["model" => $user]);
  }

  public function profile()
  {
    return $this->render("profile");
  }

  // Soufiane i must specify the "Request $request" parameter to use $response correctly !!! parameter order
  public function logout(Request $request, Response $response): void
  {
    Application::$app->logout();
    $response->redirect("/");
    return;
  }
}
