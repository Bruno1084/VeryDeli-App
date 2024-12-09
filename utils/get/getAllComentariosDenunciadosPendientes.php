<?php
function getAllComentariosDenunciadosPendientes($limit = 0, $offset = 0) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
    $db = new DB();
    $conexion=$db->getConnection();
    $sql='SELECT 
            comentarios.comentario_id,
            comentarios.comentario_mensaje,
            denuncias_reportadas.reporte_fecha,
            comentarios.publicacion_id,
            usuarios.usuario_usuario,
            CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
            CASE WHEN usuarios.usuario_esVerificado = "1" THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto
        FROM 
            comentarios
        LEFT JOIN
            usuarios ON usuarios.usuario_id=comentarios.usuario_id
        LEFT JOIN 
            fotosPerfil ON fotosPerfil.usuario_id = comentarios.usuario_id AND fotosPerfil.imagen_estado = "1"
        LEFT JOIN 
            userMarcoFoto ON userMarcoFoto.usuario_id=comentarios.usuario_id
        LEFT JOIN
            marcos ON marcos.marco_id = userMarcoFoto.marco_id
        LEFT JOIN
            denuncias_reportadas ON denuncias_reportadas.comentario_id = comentarios.comentario_id
            AND denuncias_reportadas.reporte_activo="1"
        WHERE
            comentarios.comentario_esActivo="1" AND comentarios.comentario_id = ?
            AND denuncias_reportadas.publicacion_id IS NOT NULL
        GROUP BY comentarios.comentario_id,
                 usuarios.usuario_usuario
        ORDER BY denuncias_reporatas.reporte_fecha ASC
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
