<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/components/publicacionExtendida.php");?>
  <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");?>
  <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getPublicacion.php");?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/components/JS.php');?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <div class="d-flex justify-content-center">
    <div class="form-rest my-4 col-8"></div>
  </div>
  <?php 
    $publicacion = getPublicacion($_GET['id']);

    $imagenes = json_decode($publicacion['imagenes'], true);

    
    echo renderPublicacionExtendida(
      $publicacion['publicacion_id'],
      $publicacion['usuario_usuario'],
      "",
      $publicacion['publicacion_fecha'],
      $publicacion['usuario_localidad'],
      $publicacion['publicacion_descr'],
      $publicacion['publicacion_peso'],
      $publicacion['ubicacion_origen'],
      $publicacion['ubicacion_destino'],
      $imagenes
    );
  ?>

  <?php require_once("../components/Footer.php");?>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/postulacion.js"></script>
  <script src="/js/ajax.js"></script>
  <script src="/js/validarReporte.js"></script>
</body>
</html>