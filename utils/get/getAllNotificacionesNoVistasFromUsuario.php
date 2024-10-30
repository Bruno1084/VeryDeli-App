<?php
function getNotificacionesActivasFromUsuario(){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT notificacion_mensaje FROM notificaciones WHERE notificacion_estado = '0' AND usuario_id = ?";

    $stmt=$connection->prepare($sql);

    $stmt->bindParam(1,$_SESSION["id"]);

    $stmt->execute();
    $notify=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $notify;
}
