<?php

require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

function actualizarDenuncia($id,$estado,$tipo){
    $db=new DB();
    $conexion=$db->getConnection();
    $sql="UPDATE denuncias_reportadas
              SET reporte_activo = ?,
                  adminResponsable_id = ?,       
                  fechaRevision = ?
             ";
    if($tipo=="publicacion"){
        $sql.="WHERE publicacion_id = ? ";
    }
    elseif($tipo=="comentario"){
        $sql.="WHERE comentario_id = ? ";
    }
    $fechaActual = date('Y-m-d H:i:s');
    $stmt=$conexion->prepare($sql);
    $stmt->bindParam(1,$estado,PDO::PARAM_INT);
    $stmt->bindParam(2,$_SESSION["id"],PDO::PARAM_INT);
    $stmt->bindParam(3,$fechaActual,PDO::PARAM_STR);
    $stmt->bindParam(4,$id,PDO::PARAM_INT);

    $res=$stmt->execute();

    $stmt=null;
    $conexion=null;
    $db=null;
    
    return $res;
}
