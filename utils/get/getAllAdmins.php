<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getAllAdmins(){
    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT * FROM administradores";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $DB = null;
    $stmt = null;
    $conexion = null;
    $admins=array();
    foreach($res as $admin){
        $admins[]=$admin["administrador_id"];
    }
    return $admins;
}
