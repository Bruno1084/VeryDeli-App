<?php
    
    function guardarVehiculo($usId, $tipoVehiculo, $patente, $pesoSoportado, $volumenSoportado){
        $conexion = conectarBD();
        $stmt = $conexion->prepare("INSERT INTO vehiculos (vehiculo_patente, vehiculo_tipoVehiculo, vehiculo_pesoSoportado, vehiculo_volumenSoportado, transportista_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $patente, $tipoVehiculo, $pesoSoportado, $volumenSoportado, $usId);
    
        return $stmt->execute();
    }

?>