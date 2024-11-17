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
    if($publicacion!=null)
    $reporteStmt = $conexion->prepare('INSERT INTO denuncias_reportadas (publicacion_id, usuario_autor, reporte_motivo, reporte_mensaje, reporte_fecha) VALUES (?, ?, ?, ?, ?)');
    else
    $reporteStmt = $conexion->prepare('INSERT INTO denuncias_reportadas (comentario_id, usuario_autor, reporte_motivo, reporte_mensaje, reporte_fecha) VALUES (?, ?, ?, ?, ?)');
    
    
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $fechaActual = date('Y-m-d H:i:s');

    //Parámetros
    if($publicacion!=null){
      $reporteStmt->bindParam(1, $publicacion, PDO::PARAM_INT);
    }
    else{
      $reporteStmt->bindParam(1, $comentario, PDO::PARAM_INT);
    }
      
    $reporteStmt->bindParam(2, $autor, PDO::PARAM_INT);
    $reporteStmt->bindParam(3, $motivo, PDO::PARAM_STR);
    $reporteStmt->bindParam(4, $mensaje, PDO::PARAM_STR);
    $reporteStmt->bindParam(5, $fechaActual, PDO::PARAM_STR);
    
    //Ejecución
    if($reporteStmt->execute()){
      $reporteStmt = null;
      $sql="SELECT usuario_usuario FROM usuarios WHERE usuario_id = ?";
      $stmt=$conexion->prepare($sql);
      $stmt->bindParam(1,$autor,PDO::PARAM_INT);
      $userAutor=null;
      if($stmt->execute()){
        $res=$stmt->fetch(PDO::FETCH_ASSOC);
        if($res)
        $userAutor=$res["usuario_usuario"];
      }
      if($publicacion!=null){
        $sql="SELECT usuarios.usuario_id, usuarios.usuario_correo, publicaciones.publicacion_titulo
                FROM publicaciones 
                LEFT JOIN usuarios ON 
                    usuarios.usuario_id = publicaciones.usuario_autor
                WHERE publicaciones.publicacion_id = ?
                ";
          $stmt=$conexion->prepare($sql);
          $stmt->bindParam(1,$publicacion,PDO::PARAM_INT);
          $idDenunciado=null;
          $correoDenunciado=null;
          $tituloPublicacion;
          if($stmt->execute()){
            $res=$stmt->fetch(PDO::FETCH_ASSOC);
            if($res!=false){
              $idDenunciado=$res["usuario_id"];
              $correoDenunciado=$res["usuario_correo"];
              $tituloPublicacion=$res["publicacion_titulo"];
            }
          }
          if($idDenunciado!=null&&$correoDenunciado!=null&&$tituloPublicacion!=null){
            require_once($_SERVER["DOCUMENT_ROOT"]."/utils/enviarNotificacion.php");
            $mensaje="¡Alguien a Reportado tu publicacion '".$tituloPublicacion."'!";
            enviarNotificacion($idDenunciado,
                              $mensaje,
                              $fechaActual,
                              3,
                              $publicacion);
            enviarEmailNotificacion($correoDenunciado,$mensaje);
            if($userAutor==null) $userAutor="Alguien";
            $mensaje="¡".$userAutor." a Reportado la Publicacion '".$tituloPublicacion."'!";
            enviarNotificacion(-1,
                              $mensaje,
                              $fechaActual,
                              3,
                              $publicacion,
                              $idDenunciado);
          }
          $stmt=null;
          $conexion = null;
          $db=null;
          manejarError('true', 'Reporte enviado', 'Hemos recibido tu reporte y pronto estaremos revisando la situacion',"back");
        }
        else{
          $sql="SELECT usuarios.usuario_id, usuarios.usuario_correo, publicaciones.publicacion_titulo
                FROM comentarios
                LEFT JOIN usuarios ON
                    usuarios.usuario_id = comentarios.usuario_id
                LEFT JOIN publicaciones ON 
                    publicaciones.publicacion_id = comentarios.publicacion_id
                WHERE comentarios.comentario_id = ?
                ";
          $stmt=$conexion->prepare($sql);
          $stmt->bindParam(1,$comentario,PDO::PARAM_INT);
          $idDenunciado=null;
          $correoDenunciado=null;
          $tituloPublicacion;
          if($stmt->execute()){
            $res=$stmt->fetch(PDO::FETCH_ASSOC);
            if($res!=false){
              $idDenunciado=$res["usuario_id"];
              $correoDenunciado=$res["usuario_correo"];
              $tituloPublicacion=$res["publicacion_titulo"];
            }
          }
          if($idDenunciado!=null&&$correoDenunciado!=null&&$tituloPublicacion!=null){
            require_once($_SERVER["DOCUMENT_ROOT"]."/utils/enviarNotificacion.php");
            $mensaje="¡Alguien a Reportado tu Comentario en la publicacion '".$tituloPublicacion."'!";
            enviarNotificacion($idDenunciado,
                              $mensaje,
                              $fechaActual,
                              4,
                              $publicacion);
            enviarEmailNotificacion($correoDenunciado,$mensaje);
            if($userAutor==null) $userAutor="Alguien";
            $mensaje="¡".$userAutor." a Reportado un Comentario en la publicacion '".$tituloPublicacion."'!";
            enviarNotificacion(-1,
                              $mensaje,
                              $fechaActual,
                              4,
                              $publicacion,
                              $idDenunciado);
          }
          $stmt=null;
          $conexion = null;
          $db=null;
          manejarError('true', 'Reporte enviado', 'Hemos recibido tu reporte y pronto estaremos revisando la situacion',"#");
      }
    } else {
      $reporteStmt = null;
      $conexion = null;
      $db=null;
      manejarError('false','Error inesperado', 'Ocurrio un error al momento de tomar su reporte, intente de nuevo mas tarde');
    }
  }
