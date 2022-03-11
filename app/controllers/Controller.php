<?php

namespace app\controllers;

class Controller
{
  protected $data;
  protected $model;

  public function renderView($view, $data=[])
  {
    $this->data = $data;

    ob_start();

    include ROOT . 'app' . DS . 'views' . DS . $view . '.php';
    
    $content = ob_get_contents();

    ob_get_clean();

    include ROOT . 'app' . DS . 'views' . DS . 'layout.php';
  }
}