<?php
function getNotificacionesActivasFromUsuario($limit = 0){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT notificacion_mensaje, publicacion_id FROM notificaciones WHERE notificacion_estado = '0' AND usuario_id = ? ";
    
    if ($limit > 0) {
        $sql .= " LIMIT ?";
    };

    $stmt=$connection->prepare($sql);

    $stmt->bindParam(1,$_SESSION["id"],PDO::PARAM_INT);
    $stmt->bindParam(2,$limit,PDO::PARAM_INT);


    $stmt->execute();
    $notifies=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $notifies;
}
