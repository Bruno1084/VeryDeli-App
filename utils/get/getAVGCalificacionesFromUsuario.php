<?php
function getAVGCalificacionesFromUsuario($idUsuario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT 
          AVG(calificacion_puntaje) AS calificacion_promedio, 
          COUNT(calificacion_puntaje) AS calificacion_cantidad
          FROM calificaciones 
          WHERE ? = calificaciones.usuario_calificado
          GROUP BY usuario_calificado
        ";
          
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();  

  $calificaciones = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $calificaciones;
}
