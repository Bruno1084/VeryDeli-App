<?php
function getPublicacion($id){
  require '../database/conection.php';

  $sql = "SELECT * FROM publicaciones WHERE publicacion_id = $id";
  $resultado = $conexion->$query($sql);

  if($resultado->num_rows > 0) {
    $resultado = $resultado->fetch_all(MYSQLI_ASSOC);
  } else {
    $resultado = [];
  };

  return $resultado;
}
?>