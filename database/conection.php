<?php
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

  public static function getAllComentariosFromPublicacion($publicacion_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM comentarios WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $publicacion_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $comentarios;
  }

  public static function getAllImagenesFromPublicacion ($publicacion_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM imagenes WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $publicacion_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $imagenes;
  }

  public static function getAllPostulacionesFromPublicacion ($publicacion_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM postulaciones WHERE publicacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $publicacion_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $postulaciones;
  }

  public static function borrarImagenDB($imagen_id) {
    
    $conexion = self::getConnection();

    $sql = "DELETE FROM imagenes WHERE imagen_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1, $imagen_id, PDO::PARAM_INT);
    $response=$stmt->execute();

    $stmt = null;
    $conexion = null;
    
    return $response;
  }

  public static function getAllPublicaciones(){
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM publicaciones";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
  
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
    return $publicaciones;
  }

  public static function getAllPublicacionesFromUsuario ($usuario_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM publicaciones WHERE usuario_autor = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $publicaciones;
  }

  public static function getAllUsuarios () {
    
    $conexion = self::getConnection();
    
    $sql = "SELECT * FROM usuarios";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
  
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = null;
    $conexion = null;
  
    return $resultado;
  }

  public static function getAllVehiculosFromTransportista($transportista_id) {
    
    $conexion= self::getConnection();

    $sql = "SELECT * FROM vehiculos WHERE transportista_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1,$transportista_id,PDO::PARAM_INT);
    $stmt->execute();

    $resultado= $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = null;
    $conexion = null;
  
    return $resultado;
  }

  public static function getComentario ($comentario_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM comentarios WHERE comentario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $comentario_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $comentario = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $comentario;
  }

  public static function getImagen($imagen_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM imagenes WHERE imagen_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $imagen_id, PDO::PARAM_STR);
    $stmt->execute();
  
    $imagen = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $imagen;
  }

  public static function getPostulacion($postulacion_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM postulaciones WHERE postulacion_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $postulacion_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $postulacion = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $postulacion;
  }

  public static function getUsuario($usuario_id) {
    
    $conexion = self::getConnection();
  
    $sql = "SELECT * FROM usuarios WHERE usuarioid = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
  
    $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $stmt = null;
    $conexion = null;
  
    return $usuario;
  }

  function getVehiculo($vehiculo_id) {
    
    $conexion=self::getConnection();

    $sql = "SELECT * FROM vehiculos WHERE vehiculo_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1,$vehiculo_id,PDO::PARAM_INT);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = null;
    $conexion = null;

    return $resultado;
  }

  


}