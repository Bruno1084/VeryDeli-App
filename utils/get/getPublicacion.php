<?php
function getPublicacion ($idPublicacion) {
  include_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = 'SELECT 
            publicaciones.publicacion_id,
            publicaciones.publicacion_descr,
            publicaciones.publicacion_peso,
            publicaciones.publicacion_fecha,
            usuarios.usuario_usuario, 
            usuarios.usuario_localidad,
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
          JOIN 
            usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
          JOIN 
            imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
          JOIN
              ubicaciones AS ubicacion_origen ON ubicacion_origen.ubicacion_id = publicaciones.ubicacion_origen
          JOIN
              ubicaciones AS ubicacion_destino ON ubicacion_destino.ubicacion_id = publicaciones.ubicacion_destino
          WHERE
            publicaciones.publicacion_id = ?;
        ';
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $publicacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;
  if(!empty($publicacion))$publicacion=$publicacion[0];
  return $publicacion;
}