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

  public function login()
  {
    if (isset($_COOKIE['remember'])) {
      if (preg_match('/.{12}(:).{44}/', $_COOKIE['remember'])) {
        list($selector, $authenticator) = explode(':', $_COOKIE['remember']);

        $stmt = $this->db->prepare("SELECT `token`, `user_id` FROM `auth_tokens` WHERE `selector` = ?");
        $stmt->bindValue(1, $selector);
        $stmt->execute();

        if ($token = $stmt->fetch()) {
          if (hash_equals($token['token'], hash('sha256', base64_decode($authenticator)))) {
            $stmt = $this->db->prepare("SELECT `username` FROM `users` WHERE `id` = ?");
            $stmt->bindValue(1, $token['user_id']);
            $stmt->execute();
            
            $user = $stmt->fetchColumn();
            $_SESSION['username'] = $user;
            $_SESSION['userId'] = $token['user_id'];
          }
        }
      }
    } else {
      $errors = [
        'emailErr' => '',
        'pwdErr' => ''
      ];

      if (empty($_POST['email'])) {
        $errors['emailErr'] = 'Email is required';
      } else {
        $email = trim($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['emailErr'] = 'Invalid email format';
        }
      }

      if (empty($_POST['pwd'])) {
        $errors['pwdErr'] = 'Password is required';
      } elseif (!preg_match('/^(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])/', $_POST['pwd'])) {
        $errors['pwdErr'] = 'Invalid password';
      }

      if (empty($errors['emailErr']) && empty($errors['pwdErr'])) {
        $stmt = $this->db->prepare("SELECT `id`, `pwd`, `username` FROM `users` WHERE `email` = ?");
        $stmt->bindValue(1, $email);
        $stmt->execute();

        if (!$user = $stmt->fetch()) {
          $errors['emailErr'] = 'No account associated with the email address';
        } elseif (password_verify($_POST['pwd'], $user['pwd'])) {
          $_SESSION['username'] = $user['username'];
          $_SESSION['userId'] = $user['id'];

          if (!empty($_POST['remember'])) {
            $selector = base64_encode(random_bytes(9));
            $authenticator = random_bytes(33);
        
            setcookie('remember', $selector . ':' . base64_encode($authenticator), time() + 864000, '/');

            $stmt = $this->db->prepare("INSERT INTO `auth_tokens` (`selector`, `token`, `user_id`, `expires`) VALUES (?, ?, ?, ?)");
            $stmt->bindValue(1, $selector);
            $stmt->bindValue(2, hash('sha256', $authenticator));
            $stmt->bindValue(3, $user['id']);
            $stmt->bindValue(4, date('Y-m-d H:i:s', time() + 864000));
            $stmt->execute();
          }

          return;
        } else {
          $errors['pwdErr'] = 'Password incorrect';
        }
      }

    return $errors;
    }
  }

  public function changePwd()
  {
    $errors = [
      'currPwdErr' => '',
      'newPwdErr' => ''
    ];

    if (empty($_POST['currPwd'])) {
      $errors['currPwdErr'] = 'Enter your password';
    } elseif (!preg_match('/^(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])/', $_POST['currPwd'])) {
      $errors['currPwdErr'] = 'Invalid password';
    }
    
    if (empty($_POST['newPwd']) || empty($_POST['confirmPwd'])) {
      $errors['newPwdErr'] = 'Enter a new password';
    } elseif (!preg_match('/^(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])/', $_POST['newPwd'])) {
      $errors['newPwdErr'] = 'Password must be at least 8 characters long and contain at least 1 uppercase letter, 1 lowercase letter and 1 number';
    } elseif ($_POST['newPwd'] != $_POST['confirmPwd']) {
      $errors['newPwdErr'] = 'Passwords don\'t match';
    }

    if (empty($errors['currPwdErr']) && empty($errors['newPwdErr'])) {
      $stmt = $this->db->prepare("SELECT `pwd` FROM `users` WHERE `id` = ?");
      $stmt->bindValue(1, $_SESSION['userId']);
      $stmt->execute();

      $pwd = $stmt->fetchColumn();

      if (password_verify($_POST['currPwd'], $pwd)) {
        $newPwd = password_hash($_POST['newPwd'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("UPDATE `users` SET `pwd` = ? WHERE `id` = ?");
        $stmt->bindValue(1, $newPwd);
        $stmt->bindValue(2, $_SESSION['userId']);
        $stmt->execute();

        return;
      } else {
        $errors['currPwdErr'] = 'Password incorrect';
      }
    }
    
    return $errors;
  }

  public function deleteAcc()
  {
    $userId = $_SESSION['userId'];
    $images = $this->db->query("SELECT `image` FROM `images` WHERE `user_id` = '$userId'")->fetchAll();

    foreach ($images as $image) {
      unlink(UPLOADS . $image['image']);
    }

    $this->db->query("DELETE FROM `users` WHERE `id` = '$userId'");
  }
}