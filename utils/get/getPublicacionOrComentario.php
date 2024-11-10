<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function getPublicacionOrComentario($pubOcom){
    if($pubOcom["tipo"]=="publicacion"){
        try{
            $db=new DB();
            $conexion=$db->getConnection();
            $sql='SELECT 
                    publicaciones.publicacion_id,
                    publicaciones.publicacion_titulo,
                    publicaciones.publicacion_descr,
                    publicaciones.publicacion_fecha,
                    usuarios.usuario_usuario, 
                    usuarios.usuario_localidad, 
                    imagenes.imagen_url
                FROM 
                    publicaciones 
                JOIN 
                    usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                JOIN 
                    imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                JOIN
                    ubicaciones AS ubicacion_origen ON ubicacion_origen.ubicacion_id = publicaciones.ubicacion_origen
                JOIN
                    ubicaciones AS ubicacion_destino ON ubicacion_destino.ubicacion_id = publicaciones.ubicacion_destino
                WHERE
                    (publicaciones.publicacion_esActivo="1" OR publicaciones.publicacion_esActivo="2" OR publicaciones.publicacion_esActivo="3") 
                    AND publicaciones.publicacion_id = ?;
                ';
            $stmt=$conexion->prepare($sql);
            $stmt->bindValue(1,$pubOcom["id"]);
            $res=$stmt->execute();
            if($res!=false){
                $publicacion=$stmt->fetch(PDO::FETCH_ASSOC);
                $db=null;
                $conexion=null;
                $stmt=null;
                return $publicacion;
            }
            else{
                $db=null;
                $conexion=null;
                $stmt=null;
                return false;
            }
        }
        catch(PDOException $e){
            return false;
        }
    }
    else{
        try{
            $db=new DB();
            $conexion=$db->getConnection();
            $sql='SELECT 
                    comentarios.comentario_id,
                    comentarios.comentario_mensaje,
                    comentarios.comentario_fecha,
                    comentarios.publicacion_id,
                    usuarios.usuario_usuario
                FROM 
                    comentarios
                JOIN
                    usuarios ON usuarios.usuario_id=comentarios.usuario_id
                WHERE
                    comentarios.comentario_esActivo="1" AND comentarios.comentario_id = ?;
                ';
            $stmt=$conexion->prepare($sql);
            $stmt->bindValue(1,$pubOcom["id"]);
            $res=$stmt->execute();
            if($res!=false){
                $comentario=$stmt->fetch(PDO::FETCH_ASSOC);
                $db=null;
                $conexion=null;
                $stmt=null;
                return $comentario;
            }
            else{
                $db=null;
                $conexion=null;
                $stmt=null;
                return false;
            }
        }
        catch(PDOException $e){
            return false;
        }
    }
}