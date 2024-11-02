<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/functions/manejaError.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/getExtension.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/stringRandom.php');
	

  if (isset($_POST['enviado'])) {
    require_once($_SERVER["DOCUMENT_ROOT"].'/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/ubicacion.php");
    $usuarioAutor = $_SESSION['id'];
    $db = new DB();
    $conexion = $db->getConnection();
    $stmtEsResponsable = $conexion->prepare("SELECT usuario_esResponsable FROM usuarios WHERE usuario_id = ? AND usuario_esActivo = 0");
    $stmtEsResponsable->bindParam(1, $usuarioAutor, PDO::PARAM_INT);
    if ($stmtEsResponsable->execute()) {
      $esResponsable=$stmtEsResponsable->fetch();
      if ($esResponsable==false) {
        manejarError('false','Error inesperado', "Ocurrio un error al momento de validar su estado de responsabilidad.");
        $stmtEsResponsable = null;
        $conexion=null;
        exit;
      }
    } else {
      $stmtCantPublicaciones = null;
      manejarError('false',"Error Inesperado", "Ocurrio un error al momento de validar su estado de responsabilidad.");
      exit;
    }
		// Limitar cantidad de publicaciones
    if (!$esResponsable[0]) {
      $stmtCantPublicaciones = $conexion->prepare("SELECT * FROM publicaciones WHERE usuario_autor = ? AND publicacion_esActivo = true");
      $stmtCantPublicaciones->bindParam(1, $usuarioAutor, PDO::PARAM_INT);
      if ($stmtCantPublicaciones->execute()) {
        if ($stmtCantPublicaciones->rowCount() > 3) {
          manejarError('false','Limite excedido', "Has excedido el limite de publicaciones activas.");
					$stmtCantPublicaciones = null;
					exit;
        }
      } else {
        $stmtCantPublicaciones = null;
        manejarError('false',"Error Inesperado", "Ocurrio un error al momento de validar su cantidad de publicaciones");
        exit;
      }
    }

    $fotos = $_POST["photosId"];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $volumen = $_POST['volumen'];
    $peso = $_POST['peso'];
    $recibe = $_POST['recibe'];
    $telContacto = $_POST['contacto'];
    
    $origenId = guardarUbicacion($conexion,"origen");
    if($origenId==null){
      $stmtPublicacion=null;
      $conexion=null;
      manejarError("false","Error en Origen","No se pudo guardar la ubicacion Origen");
    }
    $destinoId = guardarUbicacion($conexion,"destino");
    if($destinoId==null){
      $stmtPublicacion=null;
      $conexion=null;
      manejarError("false","Error en Destino","No se pudo guardar la ubicacion Destino");
    }
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha=date("Y-m-d H:i:s");
    $stmtPublicacion = $conexion->prepare("INSERT INTO publicaciones (publicacion_titulo, publicacion_descr, publicacion_fecha, publicacion_peso, publicacion_volumen, ubicacion_origen, ubicacion_destino, publicacion_nombreRecibe, publicacion_telefono, usuario_autor, publicacion_esActivo, usuario_transportista) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '1', null)");
    $stmtPublicacion->bindParam(1, $titulo, PDO::PARAM_STR);
    $stmtPublicacion->bindParam(2, $descripcion, PDO::PARAM_STR);
    $stmtPublicacion->bindParam(3, $fecha,PDO::PARAM_STR_NATL);
    $stmtPublicacion->bindParam(4, $peso,PDO::PARAM_STR_NATL);
    $stmtPublicacion->bindParam(5, $volumen,PDO::PARAM_STR_NATL);
    $stmtPublicacion->bindParam(6, $origenId, PDO::PARAM_INT);
    $stmtPublicacion->bindParam(7, $destinoId, PDO::PARAM_INT);
    $stmtPublicacion->bindParam(8, $recibe, PDO::PARAM_STR);
    $stmtPublicacion->bindParam(9, $telContacto,PDO::PARAM_STR_NATL);
    $stmtPublicacion->bindParam(10, $usuarioAutor, PDO::PARAM_INT);

    if ($stmtPublicacion->execute()) {
      $idPublicacion = $conexion->lastInsertId(); // Obtiene el ultimo id insertado
      $stmtPublicacion = null;
      $conexion=null;
    } else {
      $stmtPublicacion = null;
      $conexion=null;
      manejarError('false',"Error Inesperado", "Ocurrio un error al momento de subir tu publicacion, intente de nuevo más tarde");
    }
    $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    for ($i=0;$i<count($fotos);$i+=2) {
        if (!in_array($fotos[$i+1],$formatSuportPhoto)) {
          manejarError('false', 'Formato inválido', 'Se encontro un formato de imágen no valido');
        }
    }
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conectionImgBB.php");
    $dbImgBB=new DBIMG();
    $urlFotos=array();
    for($i=0;$i<count($fotos);$i+=2){
      $extencion=getExtencion($fotos[$i+1]);
      $newName=stringRandom(10).$extencion;
      $fotoFinal=array("image"=>$fotos[$i],"name"=>$newName);
      $response=$dbImgBB->guardarImagenImgBB($fotoFinal);

      if(is_array($response)) $urlFotos[]=$response;
      else manejarError('false', 'Error de Guardado',"Ocurrio un error al querer guardar la/s foto/s");

    }
    $response=$dbImgBB->guardarImagenesDB($urlFotos,$idPublicacion);
    if (!$response) {
      manejarError('false', 'Error de Guardado', 'Error al querer almacenar la/s foto/s');
    }
    manejarError('true', "Publicacion creada", 'Pubicacion creada con exito', '../public/index.php');
  }
