<?php

function getAllUsuarios () {
  require '../database/conection.php';
  
  $sql = "SELECT * FROM usuarios";
  $conexion = conectarBD();
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $resultado = $stmt->get_result();
  
  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  return $resultado;
};
?>