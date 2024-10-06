<?php

function getAllPublicaciones(){
  require '../database/conection.php';
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM publicaciones";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;
  return $publicaciones;
};