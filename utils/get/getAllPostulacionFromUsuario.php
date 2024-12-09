<?php
function getAllPostulacionFromUsuario ($idUsuario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT postulaciones.postulacion_fecha, postulaciones.postulacion_estado, postulaciones.publicacion_id 
          FROM postulaciones
          LEFT JOIN denuncias_reportadas ON denuncias_reportadas.publicacion_id=postulaciones.publicacion_id
          WHERE ? = postulaciones.usuario_postulante
                AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')
          ";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $postulacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $postulacion;
}
