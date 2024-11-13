<?php
function getAllNotificacionesFromUsuario(){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT notificacion_id,
                 notificacion_mensaje,
                 notificacion_fecha,
                 notificacion_tipo,
                 publicacion_id
          FROM notificaciones 
          WHERE usuario_id = ? ";
    
    $stmt=$connection->prepare($sql);

    $stmt->bindParam(1,$_SESSION["id"],PDO::PARAM_INT);


    $stmt->execute();
    $notifies=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $notifies;
}