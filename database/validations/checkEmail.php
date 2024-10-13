<?php

function checkEmail ($usuario_correo) {
    require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');
    $db = new DB();
    $conexion = $db->getConnection();

    $sql = "SELECT COUNT(*) FROM usuarios WHERE usuario_correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $usuario_correo, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->fetchColumn();
    $stmt->fetch();

    return $count > 0;
};