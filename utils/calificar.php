<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
  if(isset($_POST['calificacionEnviada'])){
    $publicacion = $_POST['publicacion-id'];
    $calificado = $_POST['calificado'];
    $calificador = $_POST['calificador'];
    $puntaje = (string) $_POST['puntaje'];
    $mensaje = null;
    if($_POST['mensaje']!=""){
      $mensaje = $_POST['mensaje'];
    }
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha=date("Y-m-d H:i:s");
    $tipo = $_POST['calificacion_tipo'];
    $db = new DB();
    $conexion = $db->getConnection();
    $calificarStmt = $conexion->prepare("INSERT INTO calificaciones (publicacion_id, usuario_calificado, usuario_calificador, calificacion_puntaje, calificacion_mensaje, calificacion_fecha, calificacion_tipo) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $calificarStmt->bindParam(1, $publicacion, PDO::PARAM_INT);
    $calificarStmt->bindParam(2, $calificado, PDO::PARAM_INT);
    $calificarStmt->bindParam(3, $calificador, PDO::PARAM_INT);
    $calificarStmt->bindParam(4, $puntaje, PDO::PARAM_STR);
    $calificarStmt->bindParam(5, $mensaje, PDO::PARAM_STR);
    $calificarStmt->bindParam(6, $fecha, PDO::PARAM_STR);
    $calificarStmt->bindParam(7, $tipo, PDO::PARAM_STR);
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
  