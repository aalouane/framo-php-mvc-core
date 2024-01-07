<?php

// namespace app\migrations;

use app\core\Application;

class m002_add_password_users
{
  public function UP()
  {
    $db = Application::$app->db;
    $SQL = "ALTER TABLE users ADD COLUMN password VARCHAR(255) NOT NULL;";

    $db->pdo->exec($SQL);
  }

  public function DOWN()
  {
    $db = Application::$app->db;
    $SQL = "ALTER TABLE users DROP COLUMN password;";

    $db->pdo->exec($SQL);
  }
}
