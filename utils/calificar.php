<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
  if(isset($_POST['calificacionEnviada'])){
    $calificador = $_POST['calificador'];
    $calificado = $_POST['calificado'];
    $puntaje = (string) $_POST['puntaje'];
    $publicacion = $_POST['publicacion-id'];
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha=date("Y-m-d H:i:s");
    $db = new DB();
    $conexion = $db->getConnection();
    $calificarStmt = $conexion->prepare("INSERT INTO calificaciones (publicacion_id, usuario_calificado, usuario_calificador, calificacion_puntaje, calificacion_fecha) VALUES (?, ?, ?, ?, ?)");
    $calificarStmt->bindParam(1, $publicacion, PDO::PARAM_INT);
    $calificarStmt->bindParam(2, $calificado, PDO::PARAM_INT);
    $calificarStmt->bindParam(3, $calificador, PDO::PARAM_INT);
    $calificarStmt->bindParam(4, $puntaje, PDO::PARAM_STR);
    $calificarStmt->bindParam(5, $fecha, PDO::PARAM_STR);
    if($calificarStmt->execute()){
      $usuario = getUsuario($calificado);
      manejarError('true', 'Calificacion exitosa', 'Hemos registrado tu calificacion a '.$usuario['usuario_nombre']);
      $db = null;
      $conexion = null;
      exit;
    } else {
      manejarError('false', 'Error inesperado', 'Ocurrio un momento al procesar la calificacion, intente de nuevo mas tarde.');
      $db = null;
      $conexion = null;
      exit;
    }
  }