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
    $transportista = $_SESSION['id'];
    $autor=null;
    $datos=null;
    if(empty($monto)){
      manejarError('false', 'Monto invalido', 'El monto es obligatorio para postularse');
    }
    //Validar que sea transportista
    $stmtTransportista = $conexion->query("SELECT transportista_id FROM transportistas WHERE transportista_id = $transportista");
    if($stmtTransportista->rowCount() == 0){
      $stmtTransportista = null;
      $conexion = null;
      manejarError('false', 'Usuario Transportista', 'Para postularse a una publicacion usted debe ser transportista');
    } else {
      $datosUsuario = $conexion->query("SELECT usuario_esResponsable, usuario_usuario FROM usuarios WHERE usuario_id = $transportista");
      if ($datosUsuario->rowCount() > 0) {
        $datos = $datosUsuario->fetch(PDO::FETCH_ASSOC);
        $stmtCantPostulaciones = $conexion->query("SELECT usuario_postulante AS postulante FROM postulaciones WHERE usuario_postulante = $transportista AND postulacion_estado = '0'");
        if($datos['usuario_esResponsable'] != 1){
          $stmtCantPostulaciones = $conexion->query("SELECT usuario_postulante AS postulante FROM postulaciones WHERE usuario_postulante = $transportista AND postulacion_estado = '0'");
          if ($stmtCantPostulaciones->rowCount()>0){
            $stmtCantPostulaciones = null;
            $stmtTransportista = null;
            $conexion = null;
            manejarError('false','Limite alcanzado', "Solo puedes tener una postulacion activa.");
          }
        }
        // Valida si ya el transportista ya tiene una postulacion pendiente un la publicacion
        $stmtCantPostulaciones = $conexion->query("SELECT usuario_postulante AS postulante FROM postulaciones WHERE usuario_postulante = $transportista AND postulacion_estado = '0' AND publicacion_id = $pubId");
        if ($stmtCantPostulaciones->rowCount()>0){
          $stmtCantPostulaciones = null;
          $stmtTransportista = null;
          $conexion = null;
          manejarError('false','Postulacion existente', "Ya tienes una postulacion pendiente en esta publicacion.");
        }
      } else {
        $stmtCantPostulaciones = null;
        $stmtTransportista = null;
        $conexion = null;
        manejarError('false', 'Error inesperado', 'Ha ocurrido un error al procesar tu solicitud');
      }
    }
    $stmtAutor = $conexion->query("SELECT usuario_autor FROM publicaciones WHERE publicacion_id = $pubId");
    if ($stmtAutor->rowCount() == 1) {
      $autor = $stmtAutor->fetch(PDO::FETCH_ASSOC);
      $autor=$autor["usuario_autor"];
      if($autor == $transportista) {
        $conexion = null;
        $stmtAutor = null;
        manejarError('false', 'Eres el autor', 'No puedes postularte a tu propia publicacion!');
      }
    }
    $stmtAutor = null;
    
    $stmtPostularse = $conexion->prepare('INSERT INTO postulaciones (usuario_postulante, postulacion_precio, postulacion_descr, publicacion_id, postulacion_fecha) VALUES (?, ?, ?, ?, ?)');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechaActual = date('Y-m-d H:i:s');
    $stmtPostularse->bindParam(1, $transportista, PDO::PARAM_INT);
    $stmtPostularse->bindParam(2, $monto, PDO::PARAM_INT);
    $stmtPostularse->bindParam(3, $descripcion, PDO::PARAM_STR);
    $stmtPostularse->bindParam(4, $pubId, PDO::PARAM_INT);
    $stmtPostularse->bindParam(5, $fechaActual, PDO::PARAM_STR);
    
    if($stmtPostularse->execute()) {
      $stmtPostularse = null;
      
      require_once($_SERVER["DOCUMENT_ROOT"]."/utils/enviarNotificacion.php");
      
      $sql="SELECT usuario_correo FROM usuarios WHERE usuario_id = ?";
      $stmt=$conexion->prepare($sql);
      $stmt->bindParam(1,$autor,PDO::PARAM_INT);
      $correoAutor=null;
      if($stmt->execute()){
        if($stmt->rowCount()>0){
          $correoAutor=$stmt->fetch(PDO::FETCH_ASSOC);
          $correoAutor=$correoAutor["usuario_correo"];
        }
      }
      $mensaje="¡".$datos['usuario_usuario']." se a postulado a tu publicacion!";
      enviarNotificacion($autor,$mensaje,$fechaActual,$pubId);
      if($correoAutor!=false&&$correoAutor!=null)enviarEmailNotificacion($correoAutor,$mensaje);
      $stmt=null;
      $conexion = null;
      manejarError('true', "Postulacion Realizada", 'Postulacion registrada con exito');
    } else {
      $stmtPostularse = null;
      $conexion = null;
      manejarError('false',"Error Inesperado", "Ocurrio un error al momento de realizar tu postulacion, intente de nuevo más tarde");
    } 
  }