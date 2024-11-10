<?php

function getFotoUser ($idUsuario) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
    $DB = new DB();
    $conexion = $DB->getConnection();
  
    $sql = "SELECT imagen_url AS foto FROM fotosPerfil WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
  
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $DB = null;
    $stmt = null;
    $conexion = null;
  
    return $usuario;
  };