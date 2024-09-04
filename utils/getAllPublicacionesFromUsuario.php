<?php

function getAllPublicacionesFromUsuario ($idUsuario) {
  require '../database/conection.php';

  $sql = "SELECT * FROM publicaciones WHERE usuario_autor = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('i', $idUsuario);
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