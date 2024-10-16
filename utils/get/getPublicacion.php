<?php
function getPublicacion ($idPublicacion) {
  require_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM publicaciones WHERE publicacion_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindParam(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $publicacion = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $publicacion;
};
?>