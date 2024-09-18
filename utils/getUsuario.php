<?php

function getUsuario ($id) {
  require '../database/conection.php';

  $sql = "SELECT * FROM usuarios WHERE id = ?";
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