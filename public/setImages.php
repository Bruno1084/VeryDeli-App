<?php
function setImages($url,$p_id,$url_delete){
  require '../database/conection.php';
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "INSERT INTO `imagenes` (`imagen_url`, `publicacion_id`, `imagen_url_delete`) VALUES (':url',':publicacion_id',:'url_delete')";
  $stmt = $conexion->prepare($sql);

  $stmt->bindParam(":url",$url);
  $stmt->bindParam(":publicacion_id",$p_id);
  $stmt->bindParam(":url_delete",$url_delete);
  
  $response=$stmt->execute();

  $stmt = null;
  $conexion = null;
  return $response;
};
?>