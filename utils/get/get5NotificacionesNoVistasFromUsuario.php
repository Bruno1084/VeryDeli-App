<?php
function get5NotificacionesActivasFromUsuario(){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT notificacion_mensaje, publicacion_id, notificacion_tipo
          FROM notificaciones 
          WHERE notificacion_estado = '0' AND usuario_id = ? 
          ORDER BY notificacion_fecha DESC 
          LIMIT 5 ";
    
    $stmt=$connection->prepare($sql);
    
    $stmt->bindParam(1,$_SESSION["id"],PDO::PARAM_INT);
    
    $stmt->execute();

    $notifies=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $notifies;
}
