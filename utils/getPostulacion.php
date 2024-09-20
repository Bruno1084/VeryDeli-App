<?php

function getPostulacion ($id) {
  require '../database/conection.php';
  $conexion = conectarBD();

  $sql = "SELECT * FROM postulaciones WHERE postulacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('i', $id);
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