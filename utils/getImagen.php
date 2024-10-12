<?php

function getImagen($imagen_id) {
  require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM `imagenes` WHERE `imagen_id` = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $imagen_id, PDO::PARAM_STR);
  $stmt->execute();

  $imagen = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $imagen;
}