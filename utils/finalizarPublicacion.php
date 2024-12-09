<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getPublicacion.php');
    
    $data = json_decode(file_get_contents('php://input'), true);
    $Idpublicacion = $data['id'];
    $publicacion = getPublicacion($Idpublicacion);
    
    if($publicacion['publicacion_esActivo'] != '2') {
      manejarError('false', 'Imposible finalizar publicacion', 'No puedes finalizar una publicacion sin haber aceptado un transportista primero');
      exit;
    }

    $db = new DB();
    $conexion = $db->getConnection();

    //Consulta
    $finalizarStmt = $conexion->prepare("UPDATE publicaciones SET publicacion_esActivo = '3' WHERE publicacion_id = ?");

    //Parámetros
    $finalizarStmt->bindParam(1, $Idpublicacion, PDO::PARAM_INT);

    //Ejecución
    if($finalizarStmt->execute()){
      $finalizarStmt = null;
      $conexion = null;
      manejarError('true', 'Publicacion Finalizada', 'Publicacion finalizada, recorda calificar al transportista responsable de tu solicitud', '/pages/publicacion.php?id=' . $Idpublicacion);
    } else {
      $finalizarStmt = null;
      $conexion = null;
      manejarError('false','Error inesperado', 'Ocurrio un error al momento de finalizar su publicacion, intente de nuevo mas tarde');
    }
