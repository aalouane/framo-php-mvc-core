<?php

namespace app\core;

class Database
{
  public \PDO $pdo;

  public function __construct(array $config)
  {
    $connection = $config['connection'] ?? '';
    $host = $config['host'] ?? '';
    $port = $config['port'] ?? '';
    $db_name = $config['db_name'] ?? '';
    $username = $config['username'] ?? '';
    $password = $config['password'] ?? '';

    // mysql:host=127.0.0.1;dbname=framo
    $dsn = "$connection:host=$host;port=$port;dbname=$db_name";
    $this->pdo = new \PDO($dsn, $username, $password);
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
  }

  public function applyMigrations()
  {
    $this->createMigrationsTable();
    $this->getApplieMigrations();

    $files = scandir(Application::$ROOT_PATH . "/migrations");
    if (($key = array_search(".", $files)) !== false) {
      unset($messages[$key]);
    }
    if (($key = array_search("..", $files)) !== false) {
      unset($messages[$key]);
    }

    var_dd($files);
  }

  public function createMigrationsTable()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `migrations` (
      `id` int(10) PRIMARY KEY NOT NULL,
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


}
