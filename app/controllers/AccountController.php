<?php

namespace app\controllers;

class AccountController extends Controller
{
  public function index($errors = null)
  {
    $this->renderView('account', $errors);
  }

  public function changePwd()
  {
    $this->model = new \app\models\User;
    $errors = $this->model->changePwd();

    if (!$errors) {
      $logout = new \app\controllers\LogoutController;
      $logout->index();
    } else {
      $this->index($errors);
    }
  }

  public function deleteAcc()
  {
    $this->model = new \app\models\User;
    $this->model->deleteAcc();

    $logout = new \app\controllers\LogoutController;
    $logout->index();
  }
}