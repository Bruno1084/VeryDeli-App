<?php

function getAllPostulacionesFromPublicacion ($idPublicacion) {
  require '../database/conection.php';

  $sql = "SELECT * FROM postulaciones WHERE publicacion_id = ?";
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

  return $resultado;
};
?>