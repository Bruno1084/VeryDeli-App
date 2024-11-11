<?php 
    if (isset($_POST["verificacionEnviada"])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/getExtension.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/stringRandom.php');

    $tipoDocumento = $_POST['tipoDoc'];
    $frenteDoc = $_POST["photosIdFrenteDoc"];
    $dorsoDoc = $_POST["photosIdDorsoDoc"];
    $tipoBoleta = $_POST['tipoBol'];
    $frenteBol = $_POST["photosIdFrenteBol"];
    $dorsoBol = $_POST["photosIdDorsoBol"];
    $autor = $_SESSION['id'];

    $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
    
    if (!in_array($frenteDoc[0],$formatSuportPhoto)) {
      manejarError('false', 'Formato inválido', 'La imágen del frente del documento no es un formato valido!');
      exit;
    }

    if (!in_array($dorsoDoc[0],$formatSuportPhoto)) {
      manejarError('false', 'Formato inválido', 'La imágen del dorso del documento no es un formato valido!');
      exit;
    }

    if (!in_array($frenteBol[0],$formatSuportPhoto)) {
      manejarError('false', 'Formato inválido', 'La imágen del frente de la boleta no es un formato valido!');
      exit;
    }

    if (!in_array($dorsoBol[0],$formatSuportPhoto)) {
      manejarError('false', 'Formato inválido', 'La imágen del dorso de la boleta no es un formato valido!');
      exit;
    }
    
    /*
    LOGICA PARA ALMACENAR LAS FOTOS (Tomada de ControlFormPublicacion)
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
    

    $db = new DB();
    $conexion = $db->getConnection();
    */

    manejarError('true', 'Pruebas','El formulario se envio');
  }
