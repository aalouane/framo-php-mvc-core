<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$config = [
  'userClass' => \app\models\User::class,
  'db' => [
    'connection'    => $_ENV['DB_CONNECTION'],
    'host'          => $_ENV['DB_HOST'],
    'port'          => $_ENV['DB_PORT'],
    'db_name'       => $_ENV['DB_DATABASE'],
    'username'      => $_ENV['DB_USERNAME'],
    'password'      => $_ENV['DB_PASSWORD'],
  ]
];

$app = new Application(dirname(__DIR__), $config);

// Routes:
$app->router->get('/', [SiteController::class, 'home']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'loginStore']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'registerStore']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handlingContact']);


// Lunch the main app
$app->run();


