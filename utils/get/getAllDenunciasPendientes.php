<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getAllDenunciasPendientes($limit = 0, $offset = 0){

$db=new DB();
$conexion=$db->getConnection();

$sql="  SELECT denuncias_reportadas.*
        FROM denuncias_reportadas
        LEFT JOIN publicaciones ON publicaciones.publicacion_id=denuncias_reportadas.publicacion_id
        AND publicaciones.usuario_autor=?
        LEFT JOIN comentarios ON comentarios.comentario_id=denuncias_reportadas.comentario_id
        AND comentarios.usuario_id=?
        WHERE denuncias_reportadas.reporte_activo='1'
        AND publicaciones.usuario_autor IS NULL
        AND comentarios.usuario_id IS NULL
        ORDER BY denuncias_reportadas.reporte_fecha ASC
    ";

if ($limit > 0) {
$sql .= " LIMIT ?";
};

if($offset > 0){
    $sql .= " OFFSET ?";
}

$stmt=$conexion->prepare($sql);

$stmt->bindValue(1, $_SESSION["id"], PDO::PARAM_INT);
$stmt->bindValue(2, $_SESSION["id"], PDO::PARAM_INT);
if ($limit > 0) {
    $stmt->bindValue(3, $limit, PDO::PARAM_INT);
};
if ($offset > 0){
    $stmt->bindValue(4, $offset, PDO::PARAM_INT);
};
$res=$stmt->execute();
if($res!=false){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getPublicacionOrComentarioDenunciado.php");
    $pubsYcoms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $datosPyC=array();
    foreach($pubsYcoms as $pubOcom){
        $resPoC=getPublicacionOrComentarioDenunciado($pubOcom);
        if($resPoC!=false){
            $datosPyC[]=$resPoC;
        }
    }
    return $datosPyC;
}
else{
    $db=null;
    $conexion=null;
    $stmt=null;
    return $res;
}

}