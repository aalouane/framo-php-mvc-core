<?php 


$app = new Application();

// Routes:
$app->route('/', function(){
  return "Hello World";
});

// Lunch the main app
$app->run(); 