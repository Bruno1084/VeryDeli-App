<?php
function registrarTransportista($usId){
    try {
        require_once('../database/conection.php');
        $db = new DB();
        $conexion = $db->getConnection();

        $stmt = $conexion->prepare("INSERT INTO transportistas (transportista_id) VALUES (?)");
        $stmt->bindValue(1, $usId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false; // SI retorna falso significa que falló
        }
    } catch (PDOException $e) {
        error_log("Error al insertar transportista: " . $e->getMessage());
        return false;
    } finally {
        $stmt = null;
        $conexion = null;
    }
};
?>