<?php

function checkEmail ($email) {
    require './database/conection.php';
    $db = new DB();
    $conexion = $db->getConnection();

    $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    $count = $stmt->fetchColumn();
    $stmt->fetch();

    return $count > 0;
};
?>