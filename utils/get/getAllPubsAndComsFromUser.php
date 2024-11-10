<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getAllPubsAndComsFromUser($idUser, $limit = 0, $offset = 0){

    $db=new DB();
    $conexion=$db->getConnection();

    $sql="  SELECT publicacion_id AS id, publicacion_fecha AS fecha, 'publicacion' AS tipo
            FROM publicaciones
            WHERE
            (publicaciones.publicacion_esActivo='1' OR publicaciones.publicacion_esActivo='2' OR publicaciones.publicacion_esActivo='3')
            AND publicaciones.usuario_autor=?
            UNION
            SELECT comentario_id, comentario_fecha, 'comentario'
            FROM comentarios
            WHERE comentarios.comentario_esActivo='1'
            AND comentarios.usuario_id=?
            ORDER BY fecha DESC
        ";

    if ($limit > 0) {
    $sql .= " LIMIT ?";
    };

    if($offset > 0){
        $sql .= " OFFSET ?";
    }

    $stmt=$conexion->prepare($sql);

    $stmt->bindValue(1, $idUser, PDO::PARAM_INT);
    $stmt->bindValue(2, $idUser, PDO::PARAM_INT);
    if ($limit > 0) {
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
    };
    if ($offset > 0){
        $stmt->bindValue(4, $offset, PDO::PARAM_INT);
    };
    $res=$stmt->execute();
    if($res!=false){
        require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getPublicacionOrComentario.php");
        $pubsYcoms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datosPyC=array();
        foreach($pubsYcoms as $pubOcom){
            $resPoC=getPublicacionOrComentario($pubOcom);
            if($resPoC!=false){
                $resPoC["tipo"]=$pubOcom["tipo"];
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
