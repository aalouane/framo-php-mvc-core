<?php 

require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;
use app\controllers\Controller;


$app = new Application(dirname(__DIR__));

// Routes:
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/contact', [SiteController::class, 'contact']);
$app->router->post('/contact', [SiteController::class, 'handlingContact']);

// Lunch the main app

$app->run(); 
