<?php
function getAllPublicacionesFromUsuario ($idUsuario, $limit = 0, $offset = 0) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT 
              publicaciones.publicacion_id,
              publicaciones.publicacion_titulo,
              publicaciones.publicacion_descr,
              publicaciones.publicacion_fecha,
              usuarios.usuario_usuario, 
              usuarios.usuario_localidad, 
              imagenes.imagen_url
          FROM 
              publicaciones
          JOIN 
              usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
          JOIN 
              imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
          LEFT JOIN
              denuncias_reportadas ON  denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
          WHERE
              (publicaciones.publicacion_esActivo='1' OR publicaciones.publicacion_esActivo='2' OR publicaciones.publicacion_esActivo='3') AND usuario_autor = ?
              AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3' )
          GROUP BY 
              publicaciones.publicacion_id, 
              usuarios.usuario_usuario,
              usuarios.usuario_localidad
          ORDER BY
              publicaciones.publicacion_fecha DESC
          ";

  if ($limit > 0) {
    $sql .= " LIMIT ?";
  };

  if($offset > 0){
    $sql .= " OFFSET ?";
  }

  $stmt = $conexion->prepare($sql);
  
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);

  if ($limit > 0) {
    $stmt->bindValue(2, $limit, PDO::PARAM_INT);
  };

  if ($offset > 0){
    $stmt->bindValue(3, $offset, PDO::PARAM_INT);
  };
  $stmt->execute();

  $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $publicaciones;
}
