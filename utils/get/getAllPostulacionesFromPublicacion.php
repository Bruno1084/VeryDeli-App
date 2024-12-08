<?php
function getAllPostulacionesFromPublicacion ($idPublicacion) {
  require_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM postulaciones WHERE publicacion_id = ? AND (postulacion_estado=0 OR postulacion_estado=1)";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $postulaciones;
};
