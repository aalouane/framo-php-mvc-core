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
    $saveMig = [];

    $this->createMigrationsTable();
    $appliedMig = $this->getApplieMigrations();

    $files = scandir(Application::$ROOT_PATH . "/migrations");
    // delete the '.' and '..' records
    if (($key = array_search(".", $files)) !== false) unset($files[$key]);
    if (($key = array_search("..", $files)) !== false) unset($files[$key]);
    // modify all elem of files, to extract just the name 
    $migrated = array_map(fn($file) => pathinfo($file, PATHINFO_FILENAME), $files);
    // get the migrations must be migrate
    $toApplyMig = array_diff($migrated, $appliedMig);

    foreach ($toApplyMig as $migration) {

      require_once Application::$ROOT_PATH . '/migrations/' . $migration.".php";
      // get the class name == file name
      $migration = pathinfo($migration, PATHINFO_FILENAME);
      $instance = new $migration();
      $this->log("Applying migration $migration");
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
    echo "[".date('Y-m-d H:i:s')."] - ".$message. PHP_EOL;
  }
}
