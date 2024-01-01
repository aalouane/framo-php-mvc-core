<?php 

require_once __DIR__.'/vendor/autoload.php';

use app\core\Application;


$app = new Application();

// Routes:
$app->router->get('/', function(){
  return "Hello World";
});

// Lunch the main app

$app->run(); 
