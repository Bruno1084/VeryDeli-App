<?php
function getTransportistaPublicacion ($idPublicacion) {
    require_once ($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT publicaciones.*, postulaciones.*
            FROM publicaciones
            JOIN postulaciones ON postulaciones.usuario_postulante = publicaciones.usuario_transportista
            WHERE publicaciones.publicacion_id = ? 
            AND publicaciones.usuario_transportista IS NOT NULL
            AND postulaciones.postulacion_estado = '2' ";
    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idPublicacion, PDO::PARAM_INT);
    $stmt->execute();
  
    $postulacion = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $DB = null;
    $stmt = null;
    $conexion = null;
  
    return $postulacion;
  }