<?php

  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__, 2) . DS);
  define('APP', ROOT . 'app' . DS);
  define('CONFIG', APP . 'config' . DS);
  define('CONTROLLERS', APP . 'controllers' . DS);
  define('UPLOADS', ROOT . 'public' . DS . 'uploads' . DS);
  define('MODELS', APP . 'models' . DS);
  define('VIEWS', APP . 'views' . DS);
  define('CORE', APP . 'core' . DS);
  define('URLROOT', 'http://localhost/');

  spl_autoload_register(function ($class) {
    if (file_exists(CONTROLLERS . $class . '.php')) {
      require_once CONTROLLERS . $class . '.php';
    } else if (file_exists(MODELS . $class . '.php')) {
      require_once MODELS . $class . '.php';
    } else if (file_exists(CORE . $class . '.php')) {
      require_once CORE . $class . '.php';
    }
  });

  session_start();
  Router::route();