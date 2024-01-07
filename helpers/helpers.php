<?php

if (!function_exists('var_dd')) {
  // For debugin
  function var_dd($tab)
  {
    echo "<pre>";
    var_dump($tab);
    echo "</pre>";
  }
}
