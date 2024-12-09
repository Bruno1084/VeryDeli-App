<?php
function marcarEliminadoPublicacion($id) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "UPDATE
            publicaciones
          SET
            publicacion_esActivo = '0'
          WHERE
            publicacion_id = ?
          ";
  
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);

  $res=$stmt->execute();

  $DB = null;
  $conexion = null;
  $stmt = null;

  return $res;
}
