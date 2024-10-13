<?php

function getAllImagenesFromPublicacion ($idPublicacion) {
  require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM imagenes WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $imagenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $imagenes;
};