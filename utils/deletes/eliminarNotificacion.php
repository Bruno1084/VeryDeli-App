<?php

function eliminarNotificacion($idNotify){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();

    $conexion=$db->getConnection();

    $sql="DELETE FROM notificaciones WHERE notificacion_id = ?";

    $stmt=$conexion->prepare($sql);

    $stmt->bindParam(1, $idNotify, PDO::PARAM_INT);

    $res=$stmt->execute();
    
    $stmt=null;
    $conexion=null;
    $db=null;

    return $res;
}
