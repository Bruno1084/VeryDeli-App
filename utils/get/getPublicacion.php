<?php
function getPublicacion ($idPublicacion,$denuncia=false) {
  include_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = 'SELECT 
            publicaciones.publicacion_id,
            publicaciones.publicacion_titulo,
            publicaciones.publicacion_descr,
            publicaciones.publicacion_peso,
            publicaciones.publicacion_volumen,
            publicaciones.publicacion_nombreRecibe,
            publicaciones.publicacion_telefono,
            publicaciones.publicacion_fecha,
            publicaciones.publicacion_esActivo,
            publicaciones.usuario_transportista,
            usuarios.usuario_id,
            usuarios.usuario_usuario, 
            usuarios.usuario_localidad,
            CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
              CASE WHEN usuarios.usuario_esVerificado = "1" THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto,
            JSON_OBJECT(
                "origen", JSON_OBJECT(
                    "latitud", ubicacion_origen.ubicacion_latitud,
                    "longitud", ubicacion_origen.ubicacion_longitud,
                    "barrio", ubicacion_origen.ubicacion_barrio,
                    "manzana", `ubicacion_origen`.`ubicacion_manzana-piso`,
                    "casa", `ubicacion_origen`.`ubicacion_casa-depto`
                ),
                "destino", JSON_OBJECT(
                    "latitud", ubicacion_destino.ubicacion_latitud,
                    "longitud", ubicacion_destino.ubicacion_longitud,
                    "barrio", ubicacion_destino.ubicacion_barrio,
                    "manzana", `ubicacion_destino`.`ubicacion_manzana-piso`,
                    "casa", `ubicacion_destino`.`ubicacion_casa-depto`
                )
            ) AS ubicaciones,
            JSON_ARRAYAGG(imagenes.imagen_url) AS imagenes
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
              userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
          LEFT JOIN
              marcos ON marcos.marco_id = userMarcoFoto.marco_id
          LEFT JOIN
              denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
          WHERE
            publicaciones.publicacion_id = ?
            AND (publicaciones.publicacion_esActivo = "1" OR publicaciones.publicacion_esActivo = "2" OR publicaciones.publicacion_esActivo = "3")
         ';
  if(!$denuncia) $sql.='AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo="3")';

  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;
  
  return $publicacion;
}