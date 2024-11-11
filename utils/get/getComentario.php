<?php
function getComentario ($idComentario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT * FROM comentarios WHERE comentario_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idComentario, PDO::PARAM_INT);
  $stmt->execute();  

  $comentario = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $comentario;
}
