<?php
function registrarVehiculo ($usId, $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/functions/manejaError.php");

  try {
    $DB = new DB();
    $conexion = $DB->getConnection();

    $stmt = $conexion->prepare("INSERT INTO vehiculos (vehiculo_patente, vehiculo_tipoVehiculo, vehiculo_pesoSoportado, vehiculo_volumenSoportado, transportista_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $patente, PDO::PARAM_STR);
    $stmt->bindValue(2, $tipoVehiculo, PDO::PARAM_STR);
    $stmt->bindValue(3, $pesoSoportado, PDO::PARAM_STR);
    $stmt->bindValue(4, $volumenSoportado, PDO::PARAM_STR);
    $stmt->bindValue(5, $usId, PDO::PARAM_INT);

    if($stmt->execute()){
      $DB = null;
      $stmt = null;
      $conexion = null;
      manejarError("true","Registro exitoso","El vehiculo se registro exitosamente");
    }else{
      $DB = null;
      $stmt = null;
      $conexion = null;
      manejarError("false","Error inesperado","Ocurrio un error al intentar registrar vehículo");
    }
  } catch (PDOException $e) {
    manejarError("false","Error inesperado","Ocurrio un error al intentar registrar vehículo");
  }
}
function registrarVehiculo_Sing_up ($usId, $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  try {
    $DB = new DB();
    $conexion = $DB->getConnection();

    $stmt = $conexion->prepare("INSERT INTO vehiculos (vehiculo_patente, vehiculo_tipoVehiculo, vehiculo_pesoSoportado, vehiculo_volumenSoportado, transportista_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $patente, PDO::PARAM_STR);
    $stmt->bindValue(2, $tipoVehiculo, PDO::PARAM_STR);
    $stmt->bindValue(3, $pesoSoportado, PDO::PARAM_STR_NATL);
    $stmt->bindValue(4, $volumenSoportado, PDO::PARAM_STR_NATL);
    $stmt->bindValue(5, $usId, PDO::PARAM_INT);

    $res=$stmt->execute();
    $DB = null;
    $stmt = null;
    $conexion = null;

    return $res;

  } catch (PDOException $e) {
    return false;
  }
}