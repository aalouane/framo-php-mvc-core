<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

ini_set ('display_errors', 1);
// ini_set ('display_startup_errors', 1);
// error_reporting (E_ALL);


$config = [
  'app' => [
    'name' => $_ENV["APP_NAME"],
    'env' => $_ENV["APP_ENV"],
    'debug' => $_ENV["APP_DEBUG"],
    'url' => $_ENV["APP_URL"],
  ],
  'userClass' => \app\models\User::class, // Soufiane To think
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
$app->router->get('/logout', [AuthController::class, 'logout']);
$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handlingContact']);
$app->router->get('/profile', [AuthController::class, 'profile']);


// Lunch the main app
$app->run();


