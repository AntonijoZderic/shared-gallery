<?php

namespace app\core;

class Router 
{
  public static function route()
  {
    if (!isset($_SESSION['userId']) && !empty($_COOKIE['remember'])) {
      $controller = 'app\\controllers\\LoginController';
      $action = 'login';
    } else {
      $request = trim($_SERVER['REQUEST_URI'], '/');

      if (!empty($request)) {
        $url = explode('/', $request);
        $GLOBALS['currentPage'] = $url[0];

        if ((isset($_SESSION['userId']) && ($url[0] == 'login' || $url[0] == 'register')) ||
            (!isset($_SESSION['userId']) && ($url[0] == 'account' || $url[0] == 'logout' || $url[0] == 'management')))
        {
          header('Location: ' . URLROOT);
          exit();
        }

        $controller = 'app\\controllers\\' . $url[0] . 'Controller';
      } else {
        $controller = 'app\\controllers\\HomeController';
        $GLOBALS['currentPage'] = 'home';
      }

      $action = isset($url[1]) ? $url[1] : 'index';
    }

    if (class_exists($controller)) {
      $controller = new $controller;
    } else {
      http_response_code(404);
    }

    if (method_exists($controller, $action)) {
      $controller->$action();
    } else {
      http_response_code(404);
    }
  }
}