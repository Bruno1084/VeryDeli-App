<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getAllDenunciasPendientes($limit = 0, $offset = 0){

$db=new DB();
$conexion=$db->getConnection();

$sql="  SELECT *
        FROM denuncias_reportadas
        WHERE reporte_activo='1'
        ORDER BY reporte_fecha ASC
    ";

if ($limit > 0) {
$sql .= " LIMIT ?";
};

if($offset > 0){
    $sql .= " OFFSET ?";
}

$stmt=$conexion->prepare($sql);

if ($limit > 0) {
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
};
if ($offset > 0){
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);
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