<?php

function checkEmail($email) {
    require '../database/conection.php';
    $conexion = conectarBD();

    $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $stmt->bind_result($count);
    $stmt->fetch();

    return $count > 0;
};
?>