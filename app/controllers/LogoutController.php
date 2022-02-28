<?php

class LogoutController
{
  public function index()
  {
    if (!empty($_COOKIE['remember'])) {
      setcookie('remember', '', time() - 3600, '/');
    }

    setcookie(session_name(), '', time() - 3600, '/');
    unset($_SESSION['username']);
    unset($_SESSION['userId']);
    session_destroy();

    header('Location: ' . URLROOT . 'login');
  }
}