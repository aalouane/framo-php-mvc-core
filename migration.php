<?php

use app\core\Application;

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
  'db' => [
    'connection'    => $_ENV['DB_CONNECTION'],
    'host'          => $_ENV['DB_HOST'],
    'port'          => $_ENV['DB_PORT'],
    'db_name'       => $_ENV['DB_DATABASE'],
    'username'      => $_ENV['DB_USERNAME'],
    'password'      => $_ENV['DB_PASSWORD'],
  ]
];

$app = new Application(__DIR__, $config);

// Arguments
$args = [
  "refresh" => "Refresh database : delete all tables before migrations",
];
// Get args
if (isset($argv)) {
  array_shift($argv); // the first elem = the script name

  if (!empty($argv)) {
    // Check for errors arguments
    foreach ($argv as $arg) {
      
      if (!array_key_exists($arg, $args)){
        echo "ERROR Arguments".PHP_EOL;
        echo "Arguments :".PHP_EOL;
        // Display arguments help
        foreach ($args as $key => $val) {
          echo "  ".$key." : ".$val.PHP_EOL;
        }
        exit(-1);
      }
    }

    // after checking all arguments, aply arguments
    foreach ($args as $key => $val) {
      $app->db->$key(); // call db methods
    }
  }
} else {
  echo "Args are disabled".PHP_EOL;
}


$app->db->applyMigrations();


// For debugin
function var_dd($tab)
{
  echo "<pre>";
  var_dump($tab);
  echo "</pre>";
}
