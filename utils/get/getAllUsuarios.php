<?php
function getAllUsuarios () {
  require_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM usuarios WHERE usuario_esActivo = '1'";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $DB = null;
  $stmt = null;
  $conexion = null;

  return $resultado;
};
