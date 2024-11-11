<?php 
    if (isset($_POST["verificacionEnviada"])) {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/getExtension.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/stringRandom.php');

    $tipoDocumento = $_POST['tipoDoc'];
    $tipoBoleta = $_POST['tipoBol'];
    $fotosDocumento = $_POST['photosIdDoc'];
    $fotosBoleta = $_POST['photosIdBol'];

    //------------------------------------------------------------------
    $dbImgBB=new DBIMG();

    if(!$dbImgBB->envioVerificacion())
    {
      $formatSuportPhoto=["image/png","image/jpeg","image/jpg"];
      for ($i=0;$i<count($fotosDocumento);$i+=2) {
          if (!in_array($fotosDocumento[$i+1],$formatSuportPhoto)) {
            manejarError('false', 'Formato inválido', 'Se encontro un formato de imágen no valido en la Documento');
          }
      }
      for ($i=0;$i<count($fotosBoleta);$i+=2) {
          if (!in_array($fotosBoleta[$i+1],$formatSuportPhoto)) {
            manejarError('false', 'Formato inválido', 'Se encontro un formato de imágen no valido en el Boleta');
          }
        }
        require_once($_SERVER["DOCUMENT_ROOT"]."/database/conectionImgBB.php");
      $urlFotosDoc=array();
      $urlFotosBol=array();
      for($i=0;$i<count($fotosDocumento);$i+=2){
        $extencion=getExtencion($fotosDocumento[$i+1]);
        $newName=stringRandom(10).$extencion;
        $fotoDocFinal=array("image"=>$fotosDocumento[$i],"name"=>$newName);
        $response=$dbImgBB->guardarImagenImgBB($fotoDocFinal);

        if(is_array($response)) $urlFotosDoc[]=$response;
        else manejarError('false', 'Error de Guardado',"Ocurrio un error al querer guardar la/s foto/s del Documento");

      }
      for($i=0;$i<count($fotosBoleta);$i+=2){
        $extencion=getExtencion($fotosBoleta[$i+1]);
        $newName=stringRandom(10).$extencion;
        $fotoBolFinal=array("image"=>$fotosBoleta[$i],"name"=>$newName);
        $response=$dbImgBB->guardarImagenImgBB($fotoBolFinal);

        if(is_array($response)) $urlFotosBol[]=$response;
        else manejarError('false', 'Error de Guardado',"Ocurrio un error al querer guardar la/s foto/s de la Boleta");

      }
      $response=$dbImgBB->guardarFotosVerificacionDB($urlFotosDoc,$urlFotosBol,$tipoDoc,$tipoBol);
      if (!$response) {
        manejarError('false', 'Error de Guardado', 'Error al querer almacenar la/s foto/s de la Verificacion');
      }
      manejarError('true', 'Verificacion Enviada','En las proximas 48/72 hora se le notificara el resultado');

      //------------------------------------------------------------------
      
    }
    else{
      manejarError('false', 'Verificacion Pendiente','Ya ha enviado una solicitud de verificacion');
    }
    

  }
