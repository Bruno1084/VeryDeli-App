<?php
class DB {
  private static $HOST;
  private static $PORT;
  private static $USER;
  private static $NAME;
  private static $PASSWORD;

  public function __construct () {
    self::$HOST = $_ENV['DB_HOST'];
    self::$PORT = $_ENV['DB_PORT'];
    self::$USER = $_ENV['DB_USER'];
    self::$NAME = $_ENV['DB_NAME'];
    self::$PASSWORD = $_ENV['DB_PASSWORD'];
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