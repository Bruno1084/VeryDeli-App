<?php

function getComentario ($id) {
  require_once('../database/conection.php');
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM comentarios WHERE comentario_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();

  $comentario = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $comentario;
};
?>