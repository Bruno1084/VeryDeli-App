<?php

function getAllPublicaciones(){
  require '../database/conection.php';
  $conexion = conectarBD();

  $sql = "SELECT * FROM publicaciones";
  $stmt = $conexion->prepare($sql);
  $stmt->execute();

  $resultado = $stmt->get_result();

  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  $stmt->close();
  $conexion->close();
  return $resultado;
};
?>