<?php

function getPostulacion ($id) {
  require '../database/conection.php';

  $sql = "SELECT * FROM postulaciones WHERE postulacion_id = $id";
  $resultado = $conexion->query($sql);

  if ($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  return $resultado;
};
?>