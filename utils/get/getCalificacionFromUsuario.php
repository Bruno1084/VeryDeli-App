<?php
function getCalificacionFromUsuario ($idUsuario) {
  include_once ($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT AVG(calificacion_puntaje) from calificaciones WHERE usuario_calificado = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  
  $calificacion = $stmt->fetch(PDO::FETCH_ASSOC);

  $db = null;
  $stmt = null;
  $conexion = null;

  return $calificacion;
};
?>