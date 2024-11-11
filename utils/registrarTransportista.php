<?php
function registrarTransportista ($usId) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  try {
    $DB = new DB();
    $conexion = $DB->getConnection();

    $stmt = $conexion->prepare("INSERT INTO transportistas (transportista_id) VALUES (?)");
    $stmt->bindValue(1, $usId, PDO::PARAM_INT);

    $res=$stmt->execute();
    $stmt = null;
    $conexion = null;

    return $res;
    
  } catch (PDOException $e) {
    return false;
  }
}