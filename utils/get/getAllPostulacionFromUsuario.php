<?php
function getAllPostulacionFromUsuario ($idUsuario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT postulacion_fecha, postulacion_estado, publicacion_id FROM postulaciones WHERE ? = postulaciones.usuario_postulante";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $postulacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $postulacion;
}