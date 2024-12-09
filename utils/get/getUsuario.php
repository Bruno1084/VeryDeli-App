<?php
function getUsuario ($idUsuario) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT usuarios.usuario_id, 
                 usuarios.usuario_nombre, 
                 usuarios.usuario_apellido, 
                 usuarios.usuario_correo, 
                 usuarios.usuario_localidad,
                 usuarios.usuario_usuario,
                 usuarios.usuario_esResponsable,
                 usuarios.usuario_esVerificado, 
                 CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                 CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto
           FROM usuarios 
           LEFT JOIN 
               administradores ON administradores.administrador_id = usuarios.usuario_id
           LEFT JOIN 
               fotosPerfil ON fotosPerfil.usuario_id = usuarios.usuario_id AND fotosPerfil.imagen_estado = '1'
           LEFT JOIN 
               userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
           LEFT JOIN
               marcos ON marcos.marco_id = userMarcoFoto.marco_id
           WHERE
               usuarios.usuario_id = ?
               AND usuarios.usuario_esActivo = '1'
          ";
          
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
  $stmt->execute();

  $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $usuario;
};
