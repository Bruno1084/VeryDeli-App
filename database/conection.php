<?php

define('ENV', [
  'DB_HOST' => 'mod.h.filess.io',
  'DB_PORT' => '3307',
  'DB_USER' => 'VeryDeliDB_wallyetare',
  'DB_NAME' => 'VeryDeliDB_wallyetare',
  'DB_PASSWORD' => '8ceccf7701a7f958705178390275fb31b28edf28'
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