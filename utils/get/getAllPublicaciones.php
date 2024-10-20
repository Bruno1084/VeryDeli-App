<?php
function getAllPublicaciones ($limit = 0, $offset = 0) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
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
          FROM 
              publicaciones
          JOIN 
              usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
          JOIN 
              imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
          GROUP BY 
              publicaciones.publicacion_id, 
              usuarios.usuario_usuario,
              usuarios.usuario_localidad
          ";

  if ($limit > 0) {
    $sql .= " LIMIT ?";
  };

  if($offset > 0){
    $sql .= " OFFSET ?";
  }

  $stmt = $conexion->prepare($sql);

  if ($limit > 0) {
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
  };

  if ($offset > 0){
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
  };

  $stmt->execute();

  $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $publicaciones;
};
?>