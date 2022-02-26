<?php

class Db
{
  private $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  );
  private static $instance = null;
  private $conf;
  private $dbh;
  
  public function __construct()
  {
    $this->conf = require CONFIG . 'config.php';

    try {
      $dsn = 'mysql:host=' . $this->conf['HOST'] . ';dbname=' . $this->conf['DB_NAME'];
      $this->dbh = new PDO($dsn, $this->conf['USER'], $this->conf['PASSWORD'], $this->options);

    } catch(PDOException $e) {
      if ($e->getCode() == 1049) {
        try {
          $dsn = 'mysql:host=' . $this->conf['HOST'] . ';';
          $this->dbh = new PDO($dsn, $this->conf['USER'], $this->conf['PASSWORD'], $this->options);
          $sql = 'CREATE DATABASE IF NOT EXISTS ' . $this->conf['DB_NAME'] . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
                  USE ' . $this->conf['DB_NAME'] . ';'
                  .file_get_contents(CONFIG . 'db.sql');

          $this->dbh->exec($sql);
        } catch(PDOException $e) {
          echo $e->getMessage();
        }
      }
    }
  }

  public static function getInstance()
  {
    if (!isset(self::$_instance)) {
      self::$instance = new Db;
    }

    return self::$instance->dbh;
  }
}