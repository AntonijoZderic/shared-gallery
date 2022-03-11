<?php

namespace app\controllers;

class HomeController extends Controller
{
  public function index()
  {
    $this->renderView('home');
  }

  public function getTotalImages()
  {
    $this->model = new \app\models\Image;
    echo $this->model->getTotalImages();
  }
}