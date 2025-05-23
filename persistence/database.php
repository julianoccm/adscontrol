<?php
class DatabaseConnection
{
  private static $instance = null;

  private static $host = 'localhost';
  private static $db = 'avaliacao';
  private static $user = 'root';
  private static $pass = '';

  private $pdo;

  private function __construct()
  {
    $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=utf8mb4";
    $this->pdo = new PDO($dsn, self::$user, self::$pass);
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  public function getPdo()
  {
    return $this->pdo;
  }
}