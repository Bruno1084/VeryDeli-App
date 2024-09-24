<?php

  $conexion = mysqli_connect('bjxbq3veaakujbxq3stf-mysql.services.clever-cloud.com', 'uxvwofh6wijzqx32', 'U3UIK5YAHiWbmid8E0fh', 'bjxbq3veaakujbxq3stf');

  if ($conexion) {
    echo 'La conexión a la base de datos fue exitosa';
  } else {
    echo 'Error al conectar la base de datos';
  };
  
?>