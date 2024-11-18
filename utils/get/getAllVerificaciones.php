<?php
function getAllVerificaciones() {
  require_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM verificaciones WHERE verificacion_estado='0'";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $verificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $verificaciones;
};
?>