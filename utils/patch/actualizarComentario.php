<?php
function actualizarComentario($id,$comentario){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getComentario.php");

    $preComentario=getComentario($id);
    
    if($preComentario!=false){
        if($preComentario["comentario_mensaje"]!=$comentario){
            $db=new DB();
            $conexion=$db->getConnection();

            $sql="UPDATE
                    comentarios 
                  SET 
                    comentario_mensaje = ? 
                  WHERE 
                    comentario_id = ? ";

            $stmtNewComent=$conexion->prepare($sql);
            $stmtNewComent->bindParam(1,$comentario,PDO::PARAM_STR);
            $stmtNewComent->bindParam(2,$id,PDO::PARAM_INT);
            
            $res=$stmtNewComent->execute();

            $stmtNewComent=null;
            $conexion=null;
            $db=null;

            return $res;
        }
    }
    return false;
    
}