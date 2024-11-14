<?php
function getAllPublicacionesActivas($limit = 0, $offset = 0)
{
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT 
            p.publicacion_id,
            p.publicacion_titulo,
            p.publicacion_descr,
            p.publicacion_fecha,
            u.usuario_id,
            COALESCE(fp.imagen_url, 0) AS usuario_fotoPerfil,
            u.usuario_usuario, 
            u.usuario_localidad,
            COALESCE(m.marco_url, 0) AS usuario_marcoFoto,
            i.imagen_url
            FROM 
            publicaciones p
            LEFT JOIN 
            usuarios u ON u.usuario_id = p.usuario_autor
            LEFT JOIN 
            imagenes i ON p.publicacion_id = i.publicacion_id
            LEFT JOIN 
            fotosPerfil fp ON fp.usuario_id = p.usuario_autor AND fp.imagen_estado = 1
            LEFT JOIN 
            userMarcoFoto umf ON umf.usuario_id = u.usuario_id
            LEFT JOIN 
            marcos m ON m.marco_id = umf.marco_id
            LEFT JOIN 
            publicaciones_reportadas pr ON pr.publicacion_id = p.publicacion_id
            WHERE 
            p.publicacion_esActivo = '1'
            AND pr.publicacion_id IS NULL
            GROUP BY 
            p.publicacion_id, 
            p.publicacion_titulo, 
            p.publicacion_descr, 
            p.publicacion_fecha, 
            u.usuario_id, 
            u.usuario_usuario, 
            u.usuario_localidad, 
            fp.imagen_url, 
            m.marco_url, 
            i.imagen_url
            ORDER BY 
            p.publicacion_fecha DESC";

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
