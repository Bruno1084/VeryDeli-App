<?php

function getAllPublicacionesFromUsuario ($idUsuario) {
  require '../database/conection.php';

  $sql = "SELECT * FROM publicaciones WHERE usuario_autor = $idUsuario";
  $resultado = $conexion->$query($sql);

  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  return $resultado;
}
?>