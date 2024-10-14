<?php 
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
  if(isset($_POST['enviado'])){
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    $db = new DB();
    $conexion = $db->getConnection();
    $pubId = $_POST['publicacion-id'];
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $transportista = $_SESSION['user']['usuario_id'];

    //Validar que sea transportista
    $stmtTransportista = $conexion->query("SELECT * FROM transportistas WHERE transportista_id = $transportista");
    if($stmtTransportista->rowCount() == 0){
      manejarError('false', 'Usuario Transportista', 'Para postularse a una publicacion usted debe ser transportista');
      $stmtTransportista = null;
      $conexion = null;
      exit;
    } else {
      if (!$_SESSION['user']['usuario_esResponsable']) {
        $stmtCantPostulaciones = $conexion->query("SELECT * FROM postulaciones WHERE usuarios_postulante = $transportista AND postulacion_esActiva = 1");
        if ($stmtCantPostulaciones->rowCount() == 1) {
          manejarError('false','Limite alcanzado', "Solo puedes tener una postulacion activa.");
          $stmtCantPostulaciones = null;
          $stmtTransportista = null;
          $conexion = null;
          exit;
        } 
      }
    } 
    $stmtAutor = $conexion->query("SELECT usuario_autor FROM publicaciones WHERE publicacion_id = $pubId");
    if ($stmtAutor->rowCount() == 1) {
      $stmtAutor = null;
      $conexion = null;
      manejarError('false', 'Eres el autor', 'No puedes postularte a tu propia publicacion!');
      exit;
    }

    $stmtPostularse = $conexion->prepare('INSERT INTO postulaciones (usuarios_postulante, postulacion_precio, postulacion_descr, publicacion_id, postulacion_fecha) VALUES (?, ?, ?, ?, ?)');
    $fechaActual = date('Y-m-d H:i:s');
    $stmtPostularse->bindParam(1, $transportista, PDO::PARAM_INT);
    $stmtPostularse->bindParam(2, $monto, PDO::PARAM_STR);
    $stmtPostularse->bindParam(3, $descripcion, PDO::PARAM_STR);
    $stmtPostularse->bindParam(4, $pubId, PDO::PARAM_INT);
    $stmtPostularse->bindParam(5, $fechaActual, PDO::PARAM_STR);
    if($stmtPostularse->execute()) {
      $stmtPostularse = null;
      $conexion = null;
      manejarError('true', "Postulacion Realizada", 'Postulacion registrada con exito', '../public/index.php?#');
    } else {
      $stmtPostularse = null;
      $conexion = null;
      manejarError('false',"Error Inesperado", "Ocurrio un error al momento de realizar tu postulacion, intente de nuevo más tarde");
      exit;
    }
  }