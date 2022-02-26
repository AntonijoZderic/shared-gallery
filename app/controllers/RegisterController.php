<?php

class RegisterController extends Controller
{
  public function index($errors = null)
  {
    $this->view('register', $errors);
    $this->view->render();
  }

  public function register()
  {
    $this->model('User');
    $errors = $this->model->register();

    if (!$errors) {
      header('Location: ' . URLROOT);
    } else {
      $this->index($errors);
    }
  }
}