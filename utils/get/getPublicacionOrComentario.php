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
                    CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                    CASE WHEN usuarios.usuario_esVerificado = "1" THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto,
                    imagenes.imagen_url
                FROM 
                    publicaciones 
                LEFT JOIN 
                    usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                LEFT JOIN 
                    imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                LEFT JOIN
                    ubicaciones AS ubicacion_origen ON ubicacion_origen.ubicacion_id = publicaciones.ubicacion_origen
                LEFT JOIN
                    ubicaciones AS ubicacion_destino ON ubicacion_destino.ubicacion_id = publicaciones.ubicacion_destino
                LEFT JOIN 
                    fotosPerfil ON fotosPerfil.usuario_id = publicaciones.usuario_autor AND fotosPerfil.imagen_estado = 1
                LEFT JOIN 
                    userMarcoFoto ON userMarcoFoto.usuario_id=publicaciones.usuario_autor
                LEFT JOIN
                    marcos ON marcos.marco_id = userMarcoFoto.marco_id
                LEFT JOIN
                    denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
                WHERE
                    (publicaciones.publicacion_esActivo="1" OR publicaciones.publicacion_esActivo="2" OR publicaciones.publicacion_esActivo="3") 
                    AND publicaciones.publicacion_id = ?
                    AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo="3" )
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
                    usuarios.usuario_usuario,
                    CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                    CASE WHEN usuarios.usuario_esVerificado = "1" THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto
                FROM 
                    comentarios
                LEFT JOIN
                    usuarios ON usuarios.usuario_id=comentarios.usuario_id
                LEFT JOIN 
                    fotosPerfil ON fotosPerfil.usuario_id = comentarios.usuario_id AND fotosPerfil.imagen_estado = 1
                LEFT JOIN 
                    userMarcoFoto ON userMarcoFoto.usuario_id=comentarios.usuario_id
                LEFT JOIN
                    marcos ON marcos.marco_id = userMarcoFoto.marco_id
                LEFT JOIN
                    denuncias_reportadas ON denuncias_reportadas.publicacion_id = comentarios.publicacion_id
                WHERE
                    comentarios.comentario_esActivo="1" AND comentarios.comentario_id = ?
                    AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo="3" )
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