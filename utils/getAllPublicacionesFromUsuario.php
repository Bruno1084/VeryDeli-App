<?php

function getAllPublicacionesFromUsuario ($idUsuario) {
  require '../database/conection.php';

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM publicaciones WHERE usuario_autor = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $publicaciones;
};
?>