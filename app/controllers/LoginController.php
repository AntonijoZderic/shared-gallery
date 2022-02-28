<?php

class LoginController extends Controller
{
  public function index($errors = null)
  {
    $this->view('login', $errors);
    $this->view->render();
  }

  public function login()
  {
    $this->model('User');
    $errors = $this->model->login();

    if (!$errors) {
      header('Location: ' . URLROOT);
    } else {
      $this->index($errors);
    }
  }
}