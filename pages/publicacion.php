<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php"); ?>
  <link rel="stylesheet" href="/css/publicacionExtendida.css">
  <?php
  include_once($_SERVER['DOCUMENT_ROOT'] . "/components/publicacionExtendida.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getPublicacion.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAutorPublicacion.php");
  require_once($_SERVER['DOCUMENT_ROOT'] . '/components/listaPostulaciones.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');

  ?>
   <script src="/js/cambiarEstado.js"></script>
  <title>Very Deli</title>
</head>

<body>
  <?php require_once("../components/Header.php"); ?>
  <div class="d-flex justify-content-center">
    <div class="form-rest my-4 col-8"></div>
  </div>
  <div class="primerDivBody">
    <?php
    $publicacion = getPublicacion($_GET['id']);
    if ($publicacion != false) {

      $denuncia=null;
      if(isset($_GET["denuncia"])){
        $denuncia=$_GET["denuncia"];
      }
      $autor = getAutorPublicacion($_GET['id']);
      $imagenes = json_decode($publicacion['imagenes']);

      $ubicaciones = json_decode($publicacion["ubicaciones"]);
      
      if($publicacion['publicacion_esActivo'] == "3"){
        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getCalificacionesFromPublicacion.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/funcionesCalificaciones.php');
        if ($_SESSION['id'] == $publicacion['usuario_transportista']) {
          $calificaciones = getCalificacionesFromPublicacion($_GET['id']);
          if(!empty($calificaciones)){
            $calificacionTransportista = [];
            if(count($calificaciones) == 2){
              renderCalificaciones($calificaciones);
            } else {
              foreach($calificaciones as $calificacion){
                if($calificacion['usuario_calificado'] == $_SESSION['id']){
                  $calificacionTransportista[] = $calificacion;
                }
              }
              if(!empty($calificacionTransportista)) {
                renderCalificaciones($calificacionTransportista);
              }
            }
            
            
          } 
        }
      }
      
      // Renderiza postulaciones solo si la publicación le pertenece al usuario 
      if($_SESSION['id'] == $autor['usuario_autor']){
        echo renderPostulaciones($_GET['id']);
      }
      
      $foto=array("foto"=>$publicacion["usuario_fotoPerfil"],"marco"=>$publicacion["usuario_marcoFoto"]);
      if($denuncia!=null){
        echo renderPublicacionExtendida(
          $publicacion['publicacion_id'],
          $autor,
          $publicacion['usuario_usuario'],
          $foto,
          $publicacion['publicacion_fecha'],
          $publicacion['usuario_localidad'],
          $publicacion['publicacion_descr'],
          $publicacion['publicacion_peso'],
          $ubicaciones->origen->barrio,
          $ubicaciones->destino->barrio,
          $imagenes,
          $publicacion["publicacion_esActivo"],
          $denuncia
        );
      }
      else{
        echo renderPublicacionExtendida(
          $publicacion['publicacion_id'],
          $publicacion['usuario_id'],
          $publicacion['usuario_usuario'],
          $foto,
          $publicacion['publicacion_fecha'],
          $publicacion['usuario_localidad'],
          $publicacion["publicacion_titulo"],
          $publicacion['publicacion_descr'],
          $publicacion['publicacion_peso'],
          $ubicaciones->origen->barrio,
          $ubicaciones->destino->barrio,
          $imagenes,
          $publicacion["publicacion_esActivo"]
        );
      }
    }
    ?>
  </div>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/Footer.php");?>
  
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php")?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/postulacion.js"></script>
  <script src="/js/ajax.js"></script>
  <?php if(!isset($_GET["denuncia"])){?>
    <script src="/js/editYdeleteComent.js"></script>
    <script src="/js/validarReportePublicacion.js"></script>
    <script src="/js/validarReporteComentario.js"></script>
    <script src="/js/cambiarEstado.js"></script>
    <script src="/js/validarCalificacion.js"></script>
    <script src="/js/finalizarPublicacion.js"></script>
  <?php }
  else{?>
    <script src="/js/procesarDenuncia.js"></script>
<?php
  }
  ?>
</body>

</html>