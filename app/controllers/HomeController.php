<?php

class HomeController extends Controller
{
  public function index()
  {
    $this->view('home');
    $this->view->render();
  }
}