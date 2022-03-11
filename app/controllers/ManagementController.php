<?php

namespace app\controllers;

class ManagementController extends Controller
{
  public function __construct()
  {
    $this->model = new \app\models\Image;
  }

  public function index($errors = null)
  {
    $imageData = $this->model->getImages();
    $this->renderView('management', ['imageData' => $imageData, 'errors' => $errors]);
  }

  public function upload()
  {
    $errors = $this->model->upload();
    $this->index($errors);
  }

  public function delete()
  {
    $errors = $this->model->delete();
    $this->index($errors);
  }
}