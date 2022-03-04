<?php

class HomeController extends Controller
{
  public function index()
  {
    $this->view('home');
    $this->view->render();
  }

  public function getTotalImages()
  {
    $this->model('Image');
    echo $this->model->getTotalImages();
  }
}