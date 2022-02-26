<?php

class User
{
  private $db;

  public function __construct()
  {
    $this->db = Db::getInstance();
  }

  public function register()
  {
    $errors = [
      'usernameErr' => '',
      'emailErr' => '',
      'pwdErr' => ''
    ];

    if (empty($_POST['username'])) {
      $errors['usernameErr'] = 'Username is required';
    } else {
      $username = trim(preg_replace('/\s+/', ' ', $_POST['username']));

      if (!preg_match('/^[a-zA-Z0-9 ]*$/', $username)) {
        $errors['usernameErr'] = 'Username can only contain letters, numbers and spaces';
      } elseif (strlen($username) > 50) {
        $errors['usernameErr'] = 'Username cannot be longer than 50 characters';
      }
    } 

    if (empty($_POST['email'])) {
      $errors['emailErr'] = 'Email is required';
    } else {
      $email = trim($_POST['email']);

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['emailErr'] = 'Invalid email format';
      } else {
        $stmt = $this->db->prepare("SELECT 1 FROM `users` WHERE `email` = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();

        if ($stmt->fetchColumn()) {
          $errors['emailErr'] = 'Email is already in use';
        }
      }
    }

    if (empty($_POST['pwd']) || empty($_POST['pwdRepeat'])) {
      $errors['pwdErr'] = 'Password is required';
    } elseif (!preg_match('/^(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])/', $_POST['pwd'])) {
      $errors['pwdErr'] = 'Password must be at least 8 characters long and contain at least 1 uppercase letter, 1 lowercase letter and 1 number';
    } elseif ($_POST['pwd'] != $_POST['pwdRepeat']) {
      $errors['pwdErr'] = 'Passwords don\'t match';
    }

    if (empty($errors['usernameErr']) && empty($errors['pwdErr']) && empty($errors['emailErr'])) {
      $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);

      $stmt = $this->db->prepare("INSERT INTO `users` (`username`, `email`, `pwd`) VALUES (?, ?, ?)");
      $stmt->bindValue(1, $username);
      $stmt->bindValue(2, $email);
      $stmt->bindValue(3, $pwd);

      if ($stmt->execute()) {
        $_SESSION['userId'] = $this->db->lastInsertId();
        $_SESSION['username'] = $username;

        return;
      }
    }

    return $errors;
  }
}