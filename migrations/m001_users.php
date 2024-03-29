<?php

// namespace app\migrations;

use app\core\Application;

class m001_users
{
  public function UP()
  {
    $db = Application::$app->db;
    $SQL = "CREATE TABLE users(
      id INT AUTO_INCREMENT PRIMARY KEY,
      email VARCHAR(255) NOT NULL,
      firstname VARCHAR(255) NOT NULL,
      lastname VARCHAR(255) NOT NULL,
      status TINYINT Default 0,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      ) ENGINE=INNODB;";

    $db->pdo->exec($SQL);
  }

  public function DOWN()
  {
    $db = Application::$app->db;
    $SQL = "DROP TABLE users;";

    $db->pdo->exec($SQL);
  }
}
