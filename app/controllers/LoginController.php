<?php

namespace app\controllers;

class LoginController extends Controller
{
  public function index($errors = null)
  {
    $this->renderView('login', $errors);
  }

  public function login()
  {
    $this->model = new \app\models\User;
    $errors = $this->model->login();

    if (!$errors) {
      header('Location: ' . URLROOT);
    } else {
      $this->index($errors);
    }
  }
}