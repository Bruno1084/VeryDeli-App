<?php

function getAllUsuarios () {
  require_once('../database/conection.php');
  $db = new DB();
  $conexion = $db->getConnection();
  
  $sql = "SELECT * FROM usuarios";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $stmt = null;
  $conexion = null;

  return $resultado;
};