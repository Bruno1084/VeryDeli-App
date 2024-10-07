<?php

define('ENV', [
  'DB_HOST' => 'bjxbq3veaakujbxq3stf-mysql.services.clever-cloud.com',
  'DB_PORT' => '3306',
  'DB_USER' => 'uxvwofh6wijzqx32',
  'DB_NAME' => 'bjxbq3veaakujbxq3stf',
  'DB_PASSWORD' => 'U3UIK5YAHiWbmid8E0fh'
]);

class DB {
  private static $HOST;
  private static $PORT;
  private static $USER;
  private static $NAME;
  private static $PASSWORD;

  public function __construct () {
    self::$HOST = ENV['DB_HOST'];
    self::$PORT = ENV['DB_PORT'];
    self::$USER = ENV['DB_USER'];
    self::$NAME = ENV['DB_NAME'];
    self::$PASSWORD = ENV['DB_PASSWORD'];
  }

  public static function getConnection() {
    try {
      $dsn = "mysql:host=" . self::$HOST . ";port=" . self::$PORT . ";dbname=" . self::$NAME;
      $conn = new PDO($dsn, self::$USER, self::$PASSWORD, [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      ]);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      die("ERROR: " . $e->getMessage());
    }
  }
}
?>