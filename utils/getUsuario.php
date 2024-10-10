<?php

function getUsuario ($id) {
  require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');
  $db = new DB();
  $conexion = $db->getConnection();

  $sql = "SELECT * FROM usuarios WHERE id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();

  $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = null;
  $conexion = null;

  return $usuario;
};