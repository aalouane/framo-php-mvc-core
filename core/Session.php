<?php

namespace app\core;

class Session
{

  protected const FLASH_KEY = "flash_message";

  public function __construct()
  {
    session_start();

    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
    foreach ($flashMessages as $key => &$flashMessage) {
      
      $flashMessage['remove'] = true;
    }

    $_SESSION[self::FLASH_KEY] = $flashMessages;
    
  }

  public function get(string $key) : string
  {
    return $_SESSION[$key] ?? false;
  }

  public function set(string $key, string $value) : void
  {
    $_SESSION[$key] = $value;
  }

  public function remove(string $key) : void
  {
    unset($_SESSION[$key]);
  }

  public function setFlash(string $key, string $message)
  {
    $_SESSION[self::FLASH_KEY][$key] = [
      'remove' => false,
      'message' => $message,
    ];
  }

  public function getFlash(string $key)
  {
    return $_SESSION[self::FLASH_KEY][$key]['message'] ?? false;
  }

  public function __destruct()
  {
    $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];

    foreach ($flashMessages as $key => &$flashMessage) {
      if($flashMessage['remove']) {

        unset($flashMessages[$key]);
      }
    }

    $_SESSION[self::FLASH_KEY] = $flashMessages;
  }
}
