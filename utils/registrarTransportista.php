<?php
    function registrarTransportista($usId){
        $conexion = conectarBD();
        $stmt = $conexion->prepare("INSERT INTO transportistas (transportista_id) VALUES (?)");
        $stmt->bind_param("s", $usId);
        return $stmt->execute();
    }
?>