<?php

namespace app\controllers;

class RegisterController extends Controller
{
  public function index($errors = null)
  {
    $this->renderView('register', $errors);
  }

  public function register()
  {
    $this->model = new \app\models\User;
    $errors = $this->model->register();

    if (!$errors) {
      header('Location: ' . URLROOT);
    } else {
      $this->index($errors);
    }
  }
}