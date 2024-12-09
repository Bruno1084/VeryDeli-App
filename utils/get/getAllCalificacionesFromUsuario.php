<?php
function getAllCalificacionesFromUsuario($idUsuario, $limit = 0, $offset = 0, $order=false, $tipo=false, $stars=false){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT publicacion_id,
                 calificacion_puntaje,
                 calificacion_mensaje,
                 calificacion_fecha,
                 calificacion_tipo
          FROM `calificaciones` 
          WHERE usuario_calificado= ? AND calificacion_mensaje IS NOT NULL";
    
    if($tipo==1)$sql.=" AND calificacion_tipo='1'";
    elseif($tipo==2)$sql.=" AND calificacion_tipo='2'";
    
    if($stars){
        switch($stars){
            case 1: $sql.=" AND calificacion_puntaje='1'";
                    break;
            case 2: $sql.=" AND calificacion_puntaje='2'";
                    break;
            case 3: $sql.=" AND calificacion_puntaje='3'";
                    break;
            case 4: $sql.=" AND calificacion_puntaje='4'";
                    break;
            case 5: $sql.=" AND calificacion_puntaje='5'";
                    break;
        }
    }

    if($order)$sql.=" ORDER BY calificacion_fecha ASC";
    else $sql.=" ORDER BY calificacion_fecha DESC";
    


    if ($limit > 0) {
        $sql .= " LIMIT ?";
    };

    if($offset > 0){
        $sql .= " OFFSET ?";
    }
    
    $stmt=$connection->prepare($sql);
    
    $stmt->bindParam(1,$idUsuario,PDO::PARAM_INT);
    
    if ($limit > 0) {
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
    };

    if ($offset > 0){
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
    };

    $stmt->execute();

    $calificaciones=$stmt->fetchAll(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $calificaciones;
}

function getAllDataCalificacionesFromUsuario($idUsuario){
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

    $db=new DB();
    $connection=$db->getConnection();

    $sql="SELECT -- Información general de las calificaciones
                 SUM(calificacion_puntaje = '1') AS calif1_total,
                 SUM(calificacion_puntaje = '2') AS calif2_total,
                 SUM(calificacion_puntaje = '3') AS calif3_total,
                 SUM(calificacion_puntaje = '4') AS calif4_total,
                 SUM(calificacion_puntaje = '5') AS calif5_total,
                 AVG(calificacion_puntaje) AS calificacion_promedio_total,
                 COUNT(calificacion_puntaje) AS calificacion_cantidad_total,

                 -- Calificaciones como transportista
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '1' THEN (calificacion_puntaje = '1') ELSE 0 END) AS calif1_transportista,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '1' THEN (calificacion_puntaje = '2') ELSE 0 END) AS calif2_transportista,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '1' THEN (calificacion_puntaje = '3') ELSE 0 END) AS calif3_transportista,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '1' THEN (calificacion_puntaje = '4') ELSE 0 END) AS calif4_transportista,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '1' THEN (calificacion_puntaje = '5') ELSE 0 END) AS calif5_transportista,
                 AVG(CASE WHEN calificaciones.calificacion_tipo = '1' THEN calificacion_puntaje END) AS calificacion_promedio_transportista,
                 COUNT(CASE WHEN calificaciones.calificacion_tipo = '1' THEN calificacion_puntaje END) AS calificacion_cantidad_transportista,

                 -- Calificaciones como autor de la publicación
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '2' THEN (calificacion_puntaje = '1') ELSE 0 END) AS calif1_autor,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '2' THEN (calificacion_puntaje = '2') ELSE 0 END) AS calif2_autor,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '2' THEN (calificacion_puntaje = '3') ELSE 0 END) AS calif3_autor,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '2' THEN (calificacion_puntaje = '4') ELSE 0 END) AS calif4_autor,
                 SUM(CASE WHEN calificaciones.calificacion_tipo = '2' THEN (calificacion_puntaje = '5') ELSE 0 END) AS calif5_autor,
                 AVG(CASE WHEN calificaciones.calificacion_tipo = '2' THEN calificacion_puntaje END) AS calificacion_promedio_autor,
                 COUNT(CASE WHEN calificaciones.calificacion_tipo = '2' THEN calificacion_puntaje END) AS calificacion_cantidad_autor,

                -- Cantidad de publicaciones finalizadas
                (SELECT COUNT(DISTINCT publicaciones.publicacion_id)
                FROM publicaciones
                WHERE publicaciones.usuario_autor = calificaciones.usuario_calificado
                AND publicaciones.publicacion_esActivo = '3') AS total_publicaciones,

                -- Cantidad de postulaciones finalizadas
                (SELECT COUNT(DISTINCT postulaciones.postulacion_id)
                FROM postulaciones
                JOIN publicaciones ON publicaciones.publicacion_id = postulaciones.publicacion_id
                WHERE postulaciones.usuario_postulante = calificaciones.usuario_calificado
                AND postulaciones.postulacion_estado = '2'
                AND publicaciones.publicacion_esActivo = '3') AS total_postulaciones

        FROM 
            calificaciones
        WHERE 
            calificaciones.usuario_calificado = ?
          ";
    
    $stmt=$connection->prepare($sql);
    
    $stmt->bindParam(1,$idUsuario,PDO::PARAM_INT);
    
    $stmt->execute();

    $calificaciones=$stmt->fetch(PDO::FETCH_ASSOC);

    $db=null;
    $stmt=null;
    $connection=null;
    return $calificaciones;
}
