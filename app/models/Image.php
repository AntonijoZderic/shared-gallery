<?php

namespace app\models;

class Image 
{
  private $db;

  public function __construct()
  {
    $this->db = \app\core\Db::getInstance();
  }

  public function upload()
  {
    $name = trim(preg_replace('/\s+/', ' ', $_POST['name']));
    $errors = [
      'nameErr' => '',
      'fileErr' => ''
    ];

    if (empty($name)) {
      $errors['nameErr'] = 'Name is required';
    } elseif (!preg_match('/^[a-zA-Z0-9 ]*$/', $name)) {
      $errors['nameErr'] = 'Name can only contain letters, numbers and spaces';
    } elseif (strlen($name) > 50) {
      $errors['nameErr'] = 'Name cannot be longer than 50 characters';
    }
      
    if (empty($_FILES['image']['name'])) {
      $errors['fileErr'] = 'No image selected';
    } elseif ($_FILES['image']['error'] == 1) {
      $errors['fileErr'] = 'The image exceeds the maximum allowed size (3 MB)';
    } elseif ($_FILES['image']['error'] != 0) {
      $errors['fileErr'] = 'The image could not be uploaded';
    } else {
      $fileTmpName = $_FILES['image']['tmp_name'];
      $fileMimeType = mime_content_type($fileTmpName);
      $imageMimeTypes = ['image/png', 'image/jpeg'];

      if (in_array($fileMimeType, $imageMimeTypes)) {
        if ($fileMimeType == 'image/png') {
          $fileExt = '.png';
        } else {
          $fileExt = '.jpg';
        }
      } else {
        $errors['fileErr'] = 'Invalid file format';
      }
    }

    if (empty($errors['nameErr']) && empty($errors['fileErr'])) {
      $newFileName = uniqid('', true).$fileExt;
      $uploadDir = UPLOADS . $newFileName;

      $stmt = $this->db->prepare("INSERT INTO `images` (`user_id`, `image`, `name`) VALUES (?, ?, ?)");
      $stmt->bindValue(1, $_SESSION['userId']);
      $stmt->bindValue(2, $newFileName);
      $stmt->bindValue(3, $name);

      if ($stmt->execute()) {
        move_uploaded_file($fileTmpName, $uploadDir);

        return;
      }
    }

    return $errors;
  }

  public function getTotalImages()
  {
    return $this->db->query("SELECT COUNT(*) FROM `images`")->fetchColumn();
  }

  public function getImages()
  {
    return $this->db->query("SELECT `users`.`username`, `users`.`email`, `images`.`id`, `images`.`image`, `images`.`name`
    FROM `users` INNER JOIN `images` ON `users`.`id` = `images`.`user_id`")->fetchAll();
  }

  public function delete()
  {
    $imgId = (int)$_POST['id'];
    $userId = $_SESSION['userId'];

    if ($imgId && $image = $this->db->query("SELECT `image` FROM `images` WHERE `id` = '$imgId' AND `user_id` = '$userId'")->fetchColumn()) { 
      $this->db->query("DELETE FROM `images` WHERE `id` = '$imgId'");
      unlink(UPLOADS . $image);
    }
  }
}