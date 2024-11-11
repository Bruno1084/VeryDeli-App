<?php

function getMarcoUser ($idUsuario) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  
    $DB = new DB();
    $conexion = $DB->getConnection();
  
    $sql = "SELECT marcos.marco_url 
            FROM marcos 
            LEFT JOIN userMarcoFoto ON userMarcoFoto.marco_id = marcos.marco_id 
            AND userMarcoFoto.usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
  
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $DB = null;
    $stmt = null;
    $conexion = null;
  
    return $usuario;
  };