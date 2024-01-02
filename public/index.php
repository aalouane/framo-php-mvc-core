<?php 

require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;


$app = new Application(dirname(__DIR__));

// Routes:
$app->router->get('/','home');

$app->router->get('/contact', 'contact');

// Lunch the main app

$app->run(); 
