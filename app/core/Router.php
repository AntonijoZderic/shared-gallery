<?php

class Router 
{
  public static function route()
  {
    $request = trim($_SERVER['REQUEST_URI'], '/');

    if (!empty($request)) {
      $url = explode('/', $request);
      $controller = $url[0] . 'Controller';
    } else {
      $controller = 'HomeController';
    }

    $action = isset($url[1]) ? $url[1] : 'index';

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