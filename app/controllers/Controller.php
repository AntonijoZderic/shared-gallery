<?php

class Controller
{
  protected $view;
  protected $model;

  public function model($model)
  {
    $this->model = new $model;
  }

  public function view($view, $data=[])
  {
    $this->view = new View($view, $data);
  }
}