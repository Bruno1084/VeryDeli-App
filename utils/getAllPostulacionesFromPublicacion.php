<?php

function getAllPostulacionesFromPublicacion ($idPublicacion) {
  require '../database/conection.php';
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM postulaciones WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $postulaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $postulaciones;
};
?>