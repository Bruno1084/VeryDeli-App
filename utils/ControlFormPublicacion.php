<?php
	require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/functions/manejaError.php");
  $data=array();
  function getExtencion($text){
    return ".".explode("/",$text)[1];
  }
	echo $_POST['enviado'];
	function stringRandom(int $tam):string{
    $txt="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($txt),0, $tam);
  }
  if (isset($_POST['enviado'])) {
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
    $fotos = $_POST["photosId"];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $volumen = $_POST['volumen'];
    $peso = $_POST['peso'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $recibe = $_POST['recibe'];
    $telContacto = $_POST['contacto'];
    $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    $usuarioAutor = $_SESSION['id'];
    $db = new DB();
    $conexion = $db->getConnection();
		// Limitar cantidad de publicaciones
    if (!$_SESSION['esResponsable']) {
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
      $stmtPublicacion = $conexion->prepare("INSERT INTO publicaciones (publicacion_titulo, publicacion_descr, publicacion_peso, publicacion_volumen, publicacion_origen, publicacion_destino, publicacion_nombreRecibe, publicacion_telefono, usuario_autor, publicacion_esActivo, usuario_transportista) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, null)");
      $stmtPublicacion->bindParam(1, $titulo, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(2, $descripcion, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(3, $peso);
      $stmtPublicacion->bindParam(4, $volumen);
      $stmtPublicacion->bindParam(5, $origen, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(6, $destino, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(7, $recibe, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(8, $telContacto, PDO::PARAM_STR);
      $stmtPublicacion->bindParam(9, $usuarioAutor, PDO::PARAM_INT);
      if ($stmtPublicacion->execute()) {
				$idPub = $conexion->lastInsertId(); // Obtiene el ultimo id insertado
      } else {
        $stmtPublicacion = null;
        manejarError('false',"Error Inesperado", "Ocurrio un error al momento de subir tu publicacion, intente de nuevo más tarde");
        exit;
      }
      for ($i=0;$i<count($fotos);$i+=2) {
          if (!in_array($fotos[$i+1],$formatSuportPhoto)) {
            manejarError('false', 'Formato inválido', 'Se encontro un formato de imágen no valido');
            break;
          }
      }
      if (empty($data)) {
        require($_SERVER["DOCUMENT_ROOT"]."/database/conectionImgBB.php");
        $dbImgBB=new DBIMG();
        $urlFotos=array();
        for ($i=0;$i<count($fotos);$i+=2) {
          $extencion=getExtencion($fotos[$i+1]);
          $newName=stringRandom(10).$extencion;
          $fotoFinal=array("image"=>$fotos[$i],"name"=>$newName);
          $response=$dbImgBB->guardarImagenImgBB($fotoFinal);
          if (is_array($response)) {
            $urlFotos[]=$response;
          } else {
            manejarError('false', 'Error inesperado', $responde);
            break;
            }
          }
          if (empty($data)) {
            $response=$dbImgBB->guardarImagenesDB($urlFotos,$idPub);
            if (!$response) {
              manejarError('false', 'Error imagen', 'Error al almacenar la/las foto');
              require_once("../utils/getImagen.php");
              require_once("../utils/borrarImagenImgBB.php");
              foreach ($urlFotos as $foto) {
                $tmpImg=getImagen($foto["imagen_url"]);
                if (empty($tmpImg)) {
                  $response=borrarImagenImgBB($foto["delete_url"]);
                  if (!$response) {
                    manejarError('false', 'Error inesperado', 'Error al intentar eliminar la/las fotos');
                    break;
                  }
                }
              }
            }
          } else {
            require_once($_SERVER["DOCUMENT_ROOT"]."/utils/getImagen.php");
            require_once($_SERVER["DOCUMENT_ROOT"]."/utils/borrarImagenImgBB.php");
            foreach ($urlFotos as $foto) {
              $tmpImg=getImagen($foto["imagen_url"]);
              if (empty($tmpImg)) {
                $response=borrarImagenImgBB($foto["delete_url"]);
                if (!$response) {
                  manejarError('false', 'Error inesperado', 'Error al intentar eliminar la/las fotos');
                  break;
                }
              }
            }
          }
				manejarError('true', "Publicacion creada", 'Pubicacion creada con exito', '../public/index.php');
      }
  }
  if (!empty($data)) {
    manejarError('false',"Error inesperado", json_encode($data));
  }
