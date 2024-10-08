<?php

function getImagen($imagen_url) {
  require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM `imagenes` WHERE `imagen_url` = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $imagen_url, PDO::PARAM_STR);
  $stmt->execute();

  $imagen = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $imagen;
};