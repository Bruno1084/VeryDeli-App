<?php


function getAllComentarios ($idPublicacion) {
  require '../database/conection.php';

  $sql = "SELECT * FROM usuarios WHERE idUsuarios = $idPublicacion";
  $resultado = $conexion->$query($sql);

  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  return $resultado;
}
?>