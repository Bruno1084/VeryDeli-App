<?php
function getPostulacion ($idPostulacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM postulaciones WHERE postulacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPostulacion, PDO::PARAM_INT);
  $stmt->execute();

  $postulacion = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $postulacion;
};
