<?php

function getImagen($imagen_url) {
  require_once('../database/conection.php');

  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT `imagen_id` FROM `imagenes` WHERE `imagen_url` = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $imagen_url, PDO::PARAM_STR);
  $stmt->execute();

  $imagen = $stmt->fetchAll(PDO::FETCH_NUM);

  $stmt = null;
  $conexion = null;

  return $imagen;
};