<?php 
    function getAllPublicacionesBusqueda($text,$tipo,$limit = 0, $offset = 0){
        require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
        if($tipo==2){
            $db=new DB();
            $conexion=$db->getConnection();
            $sql = "SELECT 
                        publicaciones.publicacion_id,
                        publicaciones.publicacion_titulo,
                        publicaciones.publicacion_descr,
                        publicaciones.publicacion_peso,
                        publicaciones.publicacion_fecha,
                        publicaciones.ubicacion_origen,
                        publicaciones.ubicacion_destino,
                        usuarios.usuario_usuario, 
                        usuarios.usuario_localidad, 
                        JSON_ARRAYAGG(imagenes.imagen_url) AS imagenes
                    FROM 
                        publicaciones
                    JOIN 
                        usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                    JOIN 
                        imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                    WHERE 
                        LOWER(publicacion_descr) 
                    LIKE 
                        LOWER(?)
                    GROUP BY 
                        publicaciones.publicacion_id, 
                        usuarios.usuario_usuario,
                        usuarios.usuario_localidad
                    ";
    
            if ($limit > 0) {
                $sql .= " LIMIT ?";
            };
    
            if($offset > 0){
                $sql .= " OFFSET ?";
            }
    
            $stmtBusqueda = $conexion->prepare($sql);
    
            $stmtBusqueda->bindValue(1,"%".$text."%",PDO::PARAM_STR);
    
            if ($limit > 0) {
                $stmtBusqueda->bindValue(2, $limit, PDO::PARAM_INT);
            };
    
            if ($offset > 0){
                $stmtBusqueda->bindValue(3, $offset, PDO::PARAM_INT);
            };
    
            $stmtBusqueda->execute();
    
            $publicaciones = $stmtBusqueda->fetchAll(PDO::FETCH_ASSOC);
    
            $stmtBusqueda = null;
            $conexion = null;
            $db = null;
            return $publicaciones;
        }
        else if($tipo==1){
            $db=new DB();
            $conexion=$db->getConnection();
            $sql="SELECT 
                    publicaciones.publicacion_id,
                    publicaciones.publicacion_titulo,
                    publicaciones.publicacion_descr,
                    publicaciones.publicacion_peso,
                    publicaciones.publicacion_fecha,
                    publicaciones.ubicacion_origen,
                    publicaciones.ubicacion_destino,
                    usuarios.usuario_usuario, 
                    usuarios.usuario_localidad, 
                    JSON_ARRAYAGG(imagenes.imagen_url) AS imagenes
                  FROM 
                        publicaciones
                  JOIN 
                        usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                  JOIN 
                        imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                  JOIN
                        ubicaciones ON ubicaciones.ubicacion_id = publicaciones.ubicacion_origen OR ubicaciones.ubicacion_id = publicaciones.ubicacion_destino
                  WHERE
                        (ubicaciones.ubicacion_latitud<=? AND ubicaciones.ubicacion_latitud>=?) AND (ubicaciones.ubicacion_longitud<=? AND ubicaciones.ubicacion_longitud>=?) AND publicaciones.publicacion_esActivo='1'
                  GROUP BY 
                        publicaciones.publicacion_id, 
                        usuarios.usuario_usuario,
                        usuarios.usuario_localidad
                  ORDER BY
                  		publicaciones.publicacion_fecha DESC;";
            if ($limit > 0) {
                $sql .= " LIMIT ?";
            };
    
            if($offset > 0){
                $sql .= " OFFSET ?";
            }
    
            $stmtBusqueda = $conexion->prepare($sql);
            $minLat=((double)explode(",",$text)[0])+5772;
            $maxLat=((double)explode(",",$text)[0])-5772;
            $minLng=((double)explode(",",$text)[1])+5772;
            $maxLng=((double)explode(",",$text)[1])-5772;
            $stmtBusqueda->bindValue(1,$minLat,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(2,$maxLat,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(3,$minLng,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(4,$maxLng,PDO::PARAM_STR_NATL);
    
            if ($limit > 0) {
                $stmtBusqueda->bindValue(5, $limit, PDO::PARAM_INT);
            };
    
            if ($offset > 0){
                $stmtBusqueda->bindValue(6, $offset, PDO::PARAM_INT);
            };
    
            $stmtBusqueda->execute();
    
            $publicaciones = $stmtBusqueda->fetchAll(PDO::FETCH_ASSOC);
    
            $stmtBusqueda = null;
            $conexion = null;
            $db = null;
            return $publicaciones;
        }
        else{
            return array();
        }
    }
