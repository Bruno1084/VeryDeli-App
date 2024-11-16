<?php
function getAllPublicacionesActivas($limit = 0, $offset = 0)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT 
                publicaciones.publicacion_id,
                publicaciones.publicacion_titulo,
                publicaciones.publicacion_descr,
                publicaciones.publicacion_fecha,
                usuarios.usuario_id,
                CASE WHEN fotosPerfil.usuario_id IS NOT NULL THEN fotosPerfil.imagen_url ELSE 0 END AS usuario_fotoPerfil,
                usuarios.usuario_usuario, 
                usuarios.usuario_localidad,
                CASE WHEN usuarios.usuario_esVerificado = '1' THEN marcos.marco_url ELSE 0 END AS usuario_marcoFoto,
                imagenes.imagen_url
            FROM 
                publicaciones
            LEFT JOIN 
                usuarios ON usuarios.usuario_id = publicaciones.usuario_autor
            LEFT JOIN 
                imagenes ON publicaciones.publicacion_id = imagenes.publicacion_id
            LEFT JOIN 
                fotosPerfil ON fotosPerfil.usuario_id = publicaciones.usuario_autor AND fotosPerfil.imagen_estado = 1
            LEFT JOIN 
                userMarcoFoto ON userMarcoFoto.usuario_id=usuarios.usuario_id
            LEFT JOIN
                marcos ON marcos.marco_id = userMarcoFoto.marco_id
            LEFT JOIN
                denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id
            WHERE 
                publicaciones.publicacion_esActivo='1'
                AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')
            GROUP BY 
                publicaciones.publicacion_id, 
                usuarios.usuario_usuario
            ORDER BY
                publicaciones.publicacion_fecha DESC
            ";

    if ($limit > 0) {
        $sql .= " LIMIT ?";
    };

    if ($offset > 0) {
        $sql .= " OFFSET ?";
    }

    $stmt = $conexion->prepare($sql);

    $paramIndex = 1;
    if ($limit > 0) {
      $stmt->bindValue($paramIndex++, $limit, PDO::PARAM_INT);
    }
  
    if ($offset > 0) {
      $stmt->bindValue($paramIndex, $offset, PDO::PARAM_INT);
    }

    $stmt->execute();

    $publicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $DB = null;
    $stmt = null;
    $conexion = null;

    return $publicaciones;
}
