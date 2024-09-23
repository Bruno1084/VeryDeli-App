<?php
function conectarBD () {
  $conexion = mysqli_connect('sql.freedb.tech', 'freedb_VeryDeli', 'nwfXzTs!VCxac2J', 'freedb_VeryDeli');
  if ($conexion) {
    echo 'La conexión a la base de datos fue exitosa';
    return $conexion;
  } else {
    echo 'Error al conectar la base de datos';
  };
}
?>