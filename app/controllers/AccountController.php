<?php

class AccountController extends Controller
{
  public function index($errors = null)
  {
    $this->view('account', $errors);
    $this->view->render();
  }

  public function changePwd()
  {
    $this->model('User');
    $errors = $this->model->changePwd();

    if (!$errors) {
      $logout = new LogoutController;
      $logout->index();
    } else {
      $this->index($errors);
    }
  }

  public function deleteAcc()
  {
    $this->model('User');
    $this->model->deleteAcc();

    $logout = new LogoutController;
    $logout->index();
  }
}