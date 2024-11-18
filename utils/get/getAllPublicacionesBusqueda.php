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
                        publicaciones.publicacion_fecha,
                        usuarios.usuario_id,
                        CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                        usuarios.usuario_usuario, 
                        usuarios.usuario_localidad, 
                        CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto,
                        imagenes.imagen_url
                    FROM 
                        publicaciones
                    LEFT JOIN 
                        usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                    LEFT JOIN 
                        imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                    LEFT JOIN
                        fotosPerfil ON fotosPerfil.usuario_id = publicaciones.usuario_autor AND fotosPerfil.imagen_estado = 1
                    LEFT JOIN 
                        userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
                    LEFT JOIN
                        marcos ON marcos.marco_id = userMarcoFoto.marco_id
                    LEFT JOIN 
                        denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
                    WHERE (LOWER(publicacion_titulo)
                        LIKE 
                            LOWER(?)
                        OR
                            LOWER(publicacion_descr)
                        LIKE 
                            LOWER(?))
                        AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')
                        AND publicaciones.publicacion_esActivo = '1'
                    GROUP BY 
                        publicaciones.publicacion_id, 
                        usuarios.usuario_usuario,
                        usuarios.usuario_localidad
                    ORDER BY
                  		publicaciones.publicacion_fecha DESC
                    ";
    
            if ($limit > 0) {
                $sql .= " LIMIT ?";
            };
    
            if($offset > 0){
                $sql .= " OFFSET ?";
            }
    
            $stmtBusqueda = $conexion->prepare($sql);
    
            $stmtBusqueda->bindValue(1,"%".$text."%",PDO::PARAM_STR);
            $stmtBusqueda->bindValue(2,"%".$text."%",PDO::PARAM_STR);
    
            if ($limit > 0) {
                $stmtBusqueda->bindValue(3, $limit, PDO::PARAM_INT);
            };
    
            if ($offset > 0){
                $stmtBusqueda->bindValue(4, $offset, PDO::PARAM_INT);
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
                    publicaciones.publicacion_fecha,
                    usuarios.usuario_id,
                    CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                    usuarios.usuario_usuario, 
                    usuarios.usuario_localidad, 
                    CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto,
                    imagenes.imagen_url
                  FROM 
                        publicaciones
                  LEFT JOIN 
                        usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
                  LEFT JOIN 
                        imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
                  LEFT JOIN
                        ubicaciones ON ubicaciones.ubicacion_id = publicaciones.ubicacion_origen OR ubicaciones.ubicacion_id = publicaciones.ubicacion_destino
                  LEFT JOIN
                      fotosPerfil ON fotosPerfil.usuario_id = publicaciones.usuario_autor AND fotosPerfil.imagen_estado = 1
                  LEFT JOIN 
                      userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
                  LEFT JOIN
                      marcos ON marcos.marco_id = userMarcoFoto.marco_id
                  LEFT JOIN 
                        denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
                  WHERE
                        publicaciones.publicacion_esActivo = '1' AND 
                        -- Cálculo de la distancia usando la fórmula Haversine
                        ( 6371 * acos( cos( radians(?) ) * cos( radians(ubicaciones.ubicacion_latitud) ) 
                        * cos( radians(ubicaciones.ubicacion_longitud) - radians(?) ) 
                        + sin( radians(?) ) * sin( radians(ubicaciones.ubicacion_latitud)) ) ) <= ?
                        AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')
                  GROUP BY 
                        publicaciones.publicacion_id, 
                        usuarios.usuario_usuario,
                        usuarios.usuario_localidad
                  ORDER BY
                  		publicaciones.publicacion_fecha DESC
                ";
            if ($limit > 0) {
                $sql .= " LIMIT ?";
            };
    
            if($offset > 0){
                $sql .= " OFFSET ?";
            }

            $radioK=(double)1;
            $centroLat=(double)explode(",",$text)[0];
            $centroLng=(double)explode(",",$text)[1];

            $stmtBusqueda = $conexion->prepare($sql);
            $stmtBusqueda->bindValue(1,$centroLat,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(2,$centroLng,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(3,$centroLat,PDO::PARAM_STR_NATL);
            $stmtBusqueda->bindValue(4,$radioK,PDO::PARAM_STR_NATL);
    
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
