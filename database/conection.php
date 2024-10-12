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
    self::$HOST = "bjxbq3veaakujbxq3stf-mysql.services.clever-cloud.com";
    self::$PORT = "3306";
    self::$USER = "uxvwofh6wijzqx32";
    self::$NAME = "bjxbq3veaakujbxq3stf";
    self::$PASSWORD = "U3UIK5YAHiWbmid8E0fh";
  }

  public static function getConnection () {
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

  public function getAllComentarios ($idPublicacion) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM comentarios WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
    $stmt->execute();

    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $comentarios;
  }

  public function getAllPostulantes () {
    $conexion = $this->getConnection();
  }

  public function getAllUsuarios () {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM usuarios";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
  
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = null;
    $conexion = null;
  
    return $resultado;
  }

  public function getAllPublicaciones () {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM publicaciones";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;
    return $publicaciones;
  }

  public function getAllPostulacionesFromPublicacion ($idPublicacion) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM postulaciones WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
    $stmt->execute();

    $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $postulaciones;
  }

  public function getAllPublicacionesFromUsuario ($idUsuario) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM publicaciones WHERE usuario_autor = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $publicaciones;
  }

  public function getAllVehiculosFromTransportista ($id) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM vehiculos WHERE transportista_id = $id";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $resultado;
  }

  public function getComentario ($idComentario) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM comentarios WHERE comentario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idComentario, PDO::PARAM_INT);
    $stmt->execute();  

    $comentario = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $comentario;
  }

  public function getPostulacion ($idPostulacion) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM postulaciones WHERE postulacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idPostulacion, PDO::PARAM_INT);
    $stmt->execute();

    $postulacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $postulacion;
  }

  public function getPublicacion ($idPublicacion) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM publicaciones WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $idPublicacion, PDO::PARAM_INT);
    $stmt->execute();
  
    $publicacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $publicacion;
  }

  public function getUsuario ($idUsuario) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
  
    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $usuario;
  }

  public function getVehiculo ($idVehiculo) {
    $conexion = $this->getConnection();

    $sql = "SELECT * FROM vehiculos WHERE vehiculo_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idVehiculo, PDO::PARAM_INT);
    $stmt->execute();

    $vehiculo = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;
  
    return $vehiculo;
  }

  public function registrarTransportista ($usId) {
    try {
      $conexion = $this->getConnection();

      $stmt = $conexion->prepare("INSERT INTO transportistas (transportista_id) VALUES (?)");
      $stmt->bindValue(1, $usId, PDO::PARAM_INT);

      if ($stmt->execute()) {
        return true;
      } else {
        return false; // SI retorna falso significa que falló
      }
    } catch (PDOException $e) {
      error_log("Error al insertar transportista: " . $e->getMessage());
      return false;
    } finally {
      $stmt = null;
      $conexion = null;
    }
  }

  public function registrarVehiculo ($usId, $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado) {
    try {
      $conexion = $this->getConnection();

      $stmt = $conexion->prepare("INSERT INTO vehiculos (vehiculo_patente, vehiculo_tipoVehiculo, vehiculo_pesoSoportado, vehiculo_volumenSoportado, transportista_id) VALUES (?, ?, ?, ?, ?)");
      $stmt->bindValue(1, $patente, PDO::PARAM_STR);
      $stmt->bindValue(2, $tipoVehiculo, PDO::PARAM_STR);
      $stmt->bindValue(3, $pesoSoportado, PDO::PARAM_STR);
      $stmt->bindValue(4, $volumenSoportado, PDO::PARAM_STR);
      $stmt->bindValue(5, $usId, PDO::PARAM_INT);

      return $stmt->execute();

      if ($stmt->execute()) {
        return true;
      } else {
        return false; // SI retorna falso significa que falló
      }
    } catch (PDOException $e) {
      error_log("Error al registrar vehículo: " . $e->getMessage());
      return false;
    } finally {
      $stmt = null;
      $conexion = null;
    }
  }
};
