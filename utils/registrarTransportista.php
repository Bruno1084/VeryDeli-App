<?php
    function registrarTransportista($usId){
        require_once("../database/conection.php");
        $stmt = $conexion->prepare("INSERT INTO transportistas transportista_id VALUES ?");
        $stmt->bind_param("s", $usId);

        return $stmt->execute();
    }
?>