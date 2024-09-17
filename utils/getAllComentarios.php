<?php

function getAllComentarios ($idPublicacion) {
  require '../database/conection.php';
  $conexion = conectarBD();

  $sql = "SELECT * FROM comentarios WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('i', $idPublicacion);
  $stmt->execute();

  $resultado = $stmt->get_result();

  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  $stmt->close();
  $conexion->close();
  return $comentarios;
};
?>