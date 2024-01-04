<?php

namespace app\controllers;

use app\core\Controller;

class SiteController extends Controller
{

  public function home()
  {
    $params = [
      "name" => "Soufiane",
      "age" => 36
    ];

    return $this->render("home", $params);
  }

  public function contact()
  {
    return $this->render("contact");
  }

  public function handlingContact()
  {
    return "handlingConttact";
  }

}
