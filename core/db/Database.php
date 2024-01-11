<?php

namespace app\core\db;

use app\core\Application;

class Database
{
  // to have just one Instance of Database on all life application
  public static ?\PDO $instance = null;

  public \PDO $pdo;
  public array $config;
  
  public function __construct(array $config)
  {
    $this->config = $config;
    $this->pdo = (Database::$instance) ? Database::$instance : $this->connect();
    
  }

  private function connect()
  {
    $connection = $this->config['connection'] ?? '';
    $host = $this->config['host'] ?? '';
    $port = $this->config['port'] ?? '';
    $db_name = $this->config['db_name'] ?? '';
    $username = $this->config['username'] ?? '';
    $password = $this->config['password'] ?? '';

    // mysql:host=127.0.0.1;dbname=framo
    $dsn = "$connection:host=$host;port=$port;dbname=$db_name";
    $pdo = new \PDO($dsn, $username, $password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    // Instance Singelton
    Database::$instance = $pdo;
    
    return $pdo;
  }

  public function refresh()
  {
    $sql = "drop database framo; create database framo;";
    $this->pdo->exec($sql);
    // reconnect to db
    $this->connect();
  }

  public function applyMigrations()
  {
    $saveMig = [];

    $this->createMigrationsTable();
    $appliedMig = $this->getApplieMigrations();

    $files = scandir(Application::$ROOT_PATH . "/migrations");
    // delete the '.' and '..' records
    if (($key = array_search(".", $files)) !== false) unset($files[$key]);
    if (($key = array_search("..", $files)) !== false) unset($files[$key]);
    // modify all elem of files, to extract just the name 
    $migrated = array_map(fn ($file) => pathinfo($file, PATHINFO_FILENAME), $files);
    // get the migrations must be migrate
    $toApplyMig = array_diff($migrated, $appliedMig);

    foreach ($toApplyMig as $migration) {

      require_once Application::$ROOT_PATH . '/migrations/' . $migration . ".php";
      // get the class name == file name
      $migration = pathinfo($migration, PATHINFO_FILENAME);
      $instance = new $migration();
      // $this->log("Applying migration $migration");
      $instance->up();
      $this->log("Applied migration $migration");

      $saveMig[] = $migration;
    }

    if (!empty($saveMig)) {
      $this->saveMigrations($saveMig);
    } else {
      $this->log("All migrations are applied");
    }
  }


  public function createMigrationsTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `migrations` (
      `id` int(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
      `migration` varchar(255) NOT NULL,
      `created_at`timestamp NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $this->pdo->exec($sql);
  }

  public function getApplieMigrations()
  {
    $statement = $this->pdo->prepare("SELECT migration FROM migrations");
    $statement->execute();

    return $statement->fetchAll(\PDO::FETCH_COLUMN);
  }

  public function saveMigrations($migrations)
  {
    $migration = implode(',', array_map(fn ($m) => "('$m')", $migrations));

    $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $migration");
    $statement->execute();
  }

  protected function log($message)
  {
    echo "[" . date('Y-m-d H:i:s') . "] - " . $message . PHP_EOL;
  }
}
