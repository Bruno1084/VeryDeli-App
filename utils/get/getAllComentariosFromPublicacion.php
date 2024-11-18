<?php
function getAllComentariosFromPublicacion ($idPublicacion, $denuncia=false) {
  require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "SELECT comentarios.comentario_id, 
                 comentarios.comentario_mensaje, 
                 comentarios.comentario_fecha,
                 comentarios.usuario_id,
                 usuarios.usuario_usuario,
         ";
  if($denuncia) 
  $sql .="     CASE WHEN denuncias_reportadas.comentario_id IS NOT NULL THEN true ELSE false END AS esReportado,";

  $sql .="     CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
               CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto
          FROM comentarios
          LEFT JOIN 
              usuarios ON usuarios.usuario_id=comentarios.usuario_id
          LEFT JOIN 
              fotosPerfil ON fotosPerfil.usuario_id=comentarios.usuario_id AND fotosPerfil.imagen_estado = 1
          LEFT JOIN 
              userMarcoFoto ON userMarcoFoto.usuario_id=comentarios.usuario_id
          LEFT JOIN
              marcos ON marcos.marco_id = userMarcoFoto.marco_id
          LEFT JOIN 
              denuncias_reportadas ON denuncias_reportadas.comentario_id=comentarios.comentario_id
          WHERE
              comentarios.publicacion_id = ? AND comentarios.comentario_esActivo = true
          ";
    if(!$denuncia){
        $sql.="AND (denuncias_reportadas.comentario_id IS NULL OR denuncias_reportadas.reporte_activo='3')";
    }
    $sql.="GROUP BY 
              comentarios.comentario_id
           ORDER BY 
              comentarios.comentario_fecha DESC
          ";

  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
  $stmt->execute();

  $comentarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $DB = null;
  $stmt = null;
  $conexion = null;

  return $comentarios;
};
