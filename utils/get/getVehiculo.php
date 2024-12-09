<?php
function getVehiculo ($idVehiculo) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM vehiculos WHERE vehiculo_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idVehiculo, PDO::PARAM_INT);
  $stmt->execute();

  $vehiculo = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $vehiculo;
}
