<?php
function eliminarComentario($idComentario){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $conexion=$db->getConnection();
    
    $sql="DELETE FROM comentarios WHERE comentario_id = ?";
    
    $stmtDelCom=$conexion->prepare($sql);
    $stmtDelCom->bindParam(1,$idComentario,PDO::PARAM_INT);

    $res=$stmtDelCom->execute();

    $stmtDelCom=null;
    $conexion=null;
    $db=null;

    return $res;
}
