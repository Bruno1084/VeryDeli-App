<?php

class DB {
  private static $HOST = getenv('DB_HOST');
  private static $PORT = getenv('DB_PORT');
  private static $USER = getenv('DB_USER');
  private static $NAME = getenv('DB_NAME');
  private static $PASSWORD = getenv('DB_PASSWORD');

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