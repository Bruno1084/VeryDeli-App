<?php
function getAllPublicaciones () {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT 
          publicaciones.publicacion_id,
          publicaciones.publicacion_descr,
          publicaciones.publicacion_peso,
          publicaciones.publicacion_origen,
          publicaciones.publicacion_destino,
          publicaciones.publicacion_fecha,
          usuarios.usuario_nombre, 
          usuarios.usuario_apellido, 
          usuarios.usuario_localidad, 
          imagenes.imagen_url 
          FROM 
          publicaciones
          JOIN 
          usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
          JOIN 
          imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
          GROUP BY 
          publicaciones.publicacion_id, 
          usuarios.usuario_nombre, 
          usuarios.usuario_apellido, 
          usuarios.usuario_localidad
          ;";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $publicaciones;
};
?>