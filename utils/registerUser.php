<?php

function guardarUsuario($nombre, $apellido, $correo, $localidad, $usuario, $contrasenia){
  require_once("../database/conection.php");
  $contrasenia = password_hash($contrasenia, PASSWORD_BCRYPT, ["cost"=>10]);
  $sql = $conexion->prepare("INSERT INTO usuarios (usuario_nombre, usuario_apellido, usuario_correo, usuario_localidad, usuario_usuario, usuario_contraseña) VALUES (:nombre, :apellido, :correo, :localidad, :usuario, :contrasenia)");
  // Vincular los parámetros
  $datos = [
  ":nombre" => $nombre,
  ":apellido" => $apellido,
  ":correo" => $correo,
  ":localidad" => $localidad,
  ":usuario" => $usuario,
  ":contrasenia" => $contrasenia
  ];
  $sql->execute($datos);
  $conexion = null;
}; 
?>