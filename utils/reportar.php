<?php 
    if (isset($_POST["reporteEnviado"])) {
    
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    
    $motivo = $_POST['motivo'];
    $mensaje = $_POST['mensaje'];
    $publicacion=null;
    $comentario=null;
    if(isset($_POST["publicacion-id"]))
    $publicacion = $_POST['publicacion-id'];
    else
    $comentario = $_POST["comentario-id"];
    $autor = $_SESSION['id'];
    
    $db = new DB();
    $conexion = $db->getConnection();

    //Consulta
    $reporteStmt=null;
    if(isset($_POST["publicacion_id"]))
    $reporteStmt = $conexion->prepare('INSERT INTO denuncias_reportadas (publicacion_id, usuario_autor, reporte_motivo, reporte_mensaje, reporte_fecha) VALUES (?, ?, ?, ?, ?)');
    else
    $reporteStmt = $conexion->prepare('INSERT INTO denuncias_reportadas (comentario_id, usuario_autor, reporte_motivo, reporte_mensaje, reporte_fecha) VALUES (?, ?, ?, ?, ?)');
    
    
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fecha = date('Y-m-d H:i:s');

    //Parámetros
    if($_POST["publicacion-id"]!=null){
      $reporteStmt->bindParam(1, $publicacion, PDO::PARAM_INT);
    }
    else{
      $reporteStmt->bindParam(1, $comentario, PDO::PARAM_INT);
    }
      
    $reporteStmt->bindParam(2, $autor, PDO::PARAM_INT);
    $reporteStmt->bindParam(3, $motivo, PDO::PARAM_STR);
    $reporteStmt->bindParam(4, $mensaje, PDO::PARAM_STR);
    $reporteStmt->bindParam(5, $fecha, PDO::PARAM_STR);
    
    //Ejecución
    if($reporteStmt->execute()){
      $reporteStmt = null;
      $conexion = null;
      manejarError('true', 'Reporte enviado', 'Hemos recibido tu reporte y pronto estaremos revisando la situacion');
      exit;
    } else {
      $reporteStmt = null;
      $conexion = null;
      manejarError('false','Error inesperado', 'Ocurrio un error al momento de tomar su reporte, intente de nuevo mas tarde');
      exit;
    }
  }
