<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;


$app = new Application(dirname(__DIR__));

// Routes:
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'registerStore']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handlingContact']);


// Lunch the main app
$app->run();

// For debugin
function var_dd($tab)
{
  echo "<pre>";
  var_dump($tab);
  echo "</pre>";
}
