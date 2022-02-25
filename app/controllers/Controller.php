<?php

class Controller
{
  protected $view;

  public function view($view, $data=[])
  {
    $this->view = new View($view, $data);
  }
}