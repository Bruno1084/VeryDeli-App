<?php
function getCalificacionesFromPublicacion ($idPublicacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT 
    calificaciones.calificacion_id,
    calificaciones.calificacion_puntaje,
    calificaciones.calificacion_fecha,
    calificaciones.usuario_calificador,
    calificaciones.usuario_calificado,
    usuario_calificador.usuario_usuario AS nombre_calificador,
    usuario_calificado.usuario_usuario AS nombre_calificado
    FROM 
    publicaciones
    JOIN 
    calificaciones ON publicaciones.publicacion_id = calificaciones.publicacion_id
    JOIN 
    usuarios AS usuario_calificador ON calificaciones.usuario_calificador = usuario_calificador.usuario_id
    JOIN 
    usuarios AS usuario_calificado ON calificaciones.usuario_calificado = usuario_calificado.usuario_id
    WHERE 
    publicaciones.publicacion_id = ?
      ";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();  

  $calificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $calificaciones;
}
