<?php


    function CheckEmail($Email) {
    require '../database/conection.php';

    $sql = "SELECT usuario_correo FROM usuarios WHERE usuario_correo=$Email";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
        return true;
    } else {
        return false;
    };

    }
