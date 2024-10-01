<?php

function getAllUsuarios () {
  require '../database/conection.php';
  $db = new DB();
  $conexion = $db->getConnection();
  
  $sql = "SELECT * FROM usuarios";
  $conexion = conectarBD();
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $stmt = null;
  $conexion = null;

  return $resultado;
};
?>