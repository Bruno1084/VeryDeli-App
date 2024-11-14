<?php
function getUsuario ($idUsuario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT usuario_id,
                 usuario_nombre, 
                 usuario_apellido, 
                 usuario_correo, 
                 usuario_contraseña,
                 usuario_localidad,
                 usuario_usuario
          FROM usuarios 
          WHERE usuario_id = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $usuario;
};
?>