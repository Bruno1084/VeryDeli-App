<?php
function registrarVehiculo ($usId, $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  try {
    $DB = new DB();
    $conexion = $DB->getConnection();

    $stmt = $conexion->prepare("INSERT INTO vehiculos (vehiculo_patente, vehiculo_tipoVehiculo, vehiculo_pesoSoportado, vehiculo_volumenSoportado, transportista_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindValue(1, $patente, PDO::PARAM_STR);
    $stmt->bindValue(2, $tipoVehiculo, PDO::PARAM_STR);
    $stmt->bindValue(3, $pesoSoportado, PDO::PARAM_STR);
    $stmt->bindValue(4, $volumenSoportado, PDO::PARAM_STR);
    $stmt->bindValue(5, $usId, PDO::PARAM_INT);

    return $stmt->execute();

    if ($stmt->execute()) {
      return true;
    } else {
      return false; // SI retorna falso significa que falló
    }
  } catch (PDOException $e) {
    error_log("Error al registrar vehículo: " . $e->getMessage());
    return false;
  } finally {
    $DB = null;
    $stmt = null;
    $conexion = null;
  }
}
?>