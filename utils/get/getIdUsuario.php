<?php
function getIdUsuario ($username) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT usuario_id
          FROM usuarios 
          WHERE usuario_usuario = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $username, PDO::PARAM_STR);
  $stmt->execute();

  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $usuario;
};
