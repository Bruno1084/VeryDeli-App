<?php

function getPublicacion ($id) {
  require_once('../database/conection.php');
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM publicaciones WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindParam(1, $id, PDO::PARAM_INT);
  $stmt->execute();

  $publicacion = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $publicacion;
};
?>