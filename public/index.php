<?php

  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__DIR__) . DS);
  define('UPLOADS', ROOT . 'public' . DS . 'uploads' . DS);
  define('URLROOT', 'http://localhost/');

  spl_autoload_register(function ($class) {
    require_once str_replace('\\', DS, ROOT . $class) . '.php';
  });

  session_start();
  app\core\Router::route();