<?php

class ManagementController extends Controller
{
  public function __construct()
  {
    $this->model('Image');
  }

  public function index($errors = null)
  {
    $imageData = $this->model->getImages();
  
    $this->view('management', ['imageData' => $imageData, 'errors' => $errors]);
    $this->view->render();
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