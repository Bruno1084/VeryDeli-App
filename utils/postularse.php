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
    if(empty($monto)){
      manejarError('false', 'Monto invalido', 'El monto es obligatorio para postularse');
    }
    //Validar que sea transportista
    $stmtTransportista = $conexion->query("SELECT * FROM transportistas WHERE transportista_id = $transportista");
    if($stmtTransportista->rowCount() == 0){
      $stmtTransportista = null;
      $conexion = null;
      manejarError('false', 'Usuario Transportista', 'Para postularse a una publicacion usted debe ser transportista');
    } else {
      $datosUsuario = $conexion->query("SELECT * FROM usuarios WHERE usuario_id = $transportista");
      if ($datosUsuario->rowCount() > 0) {
        $datos = $datosUsuario->fetch(PDO::FETCH_ASSOC);
        if($datos['usuario_esResponsable'] != 1){
          $stmtCantPostulaciones = $conexion->query("SELECT * FROM postulaciones WHERE usuario_postulante = $transportista AND postulacion_esActiva = 1");
          if ($stmtCantPostulaciones->rowCount() == 1) {
            $stmtCantPostulaciones = null;
            $stmtTransportista = null;
            $conexion = null;
            manejarError('false','Limite alcanzado', "Solo puedes tener una postulacion activa.");
          } 
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
      $stmt->bindParam(1,$autor);
      $correoAutor=null;
      if($stmt->execute()){
        if($stmt->rowCount()==1)$correoAutor=$stmt->fetch(PDO::FETCH_ASSOC);
      }
      $mensaje="";
      if(!enviarNotificacion($autor,$mensaje)){
      }
      if(!enviarEmailNotificacion($correoAutor,$mensaje)){
      }
      $stmt=null;
      $conexion = null;
      manejarError('true', "Postulacion Realizada", 'Postulacion registrada con exito', '../public/index.php?#');
    } else {
      $stmtPostularse = null;
      $conexion = null;
      manejarError('false',"Error Inesperado", "Ocurrio un error al momento de realizar tu postulacion, intente de nuevo más tarde");
    } 
  }