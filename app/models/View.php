<?php

class View
{
  protected $view;
  protected $data;

  public function __construct($view, $data)
  {
    $this->view = $view;
    $this->data = $data;
  }

  public function render()
  {
    ob_start();

    include VIEWS . $this->view . '.php';
    
    $content = ob_get_contents();

    ob_get_clean();

    include VIEWS . 'layout.php';
  }
}