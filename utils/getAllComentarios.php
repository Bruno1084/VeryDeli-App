<?php

function getAllComentarios($idPublicacion) {
  require '../database/conection.php';
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM comentarios WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $comentarios;
}
?>