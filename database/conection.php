<?php

  $conexion = mysqli_connect('localhost', 'root', 'Toon', 'verydeli');

  if ($conexion) {
    echo 'La conexión a la base de datos fue exitosa';
  } else {
    echo 'Error al conectar la base de datos';
  };
  
?>