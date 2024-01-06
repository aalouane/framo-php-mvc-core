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


}
