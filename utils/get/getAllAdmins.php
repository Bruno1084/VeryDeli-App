<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getAllAdmins(){
    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT * FROM administradores";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $DB = null;
    $stmt = null;
    $conexion = null;

    return $admins;
}
