<?php
function getAllVehiculosFromTransportista ($idTransportista) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM vehiculos WHERE transportista_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idTransportista, PDO::PARAM_INT);
  $stmt->execute();

  $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $vehiculos;
};
?>