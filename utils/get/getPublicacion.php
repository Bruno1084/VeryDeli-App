<?php
function getPublicacion ($idPublicacion) {
  include_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT 
            publicaciones.publicacion_id,
            publicaciones.publicacion_descr,
            publicaciones.publicacion_peso,
            publicaciones.publicacion_fecha,
            publicaciones.ubicacion_origen,
            publicaciones.ubicacion_destino,
            usuarios.usuario_usuario, 
            usuarios.usuario_localidad,
            JSON_ARRAYAGG(imagenes.imagen_url) AS imagenes
          FROM publicaciones 
          JOIN 
            usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
          JOIN 
            imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
          WHERE publicaciones.publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $publicacion;
};
?>