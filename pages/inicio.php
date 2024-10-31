<?php require_once('../utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <link rel="stylesheet" href="../css/ubicacionEnvio.css">
  <?php require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <?php require_once($_SERVER ['DOCUMENT_ROOT'].'/components/nuevaPublicacion.php') ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicaciones.php")?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllUsuarios.php")?>
  <div>
    <?php
    if(isset($_SESSION['id'])){
      echo('Bienvenido '.$_SESSION['id'].'!');
    }
    ?>

    <div class="container container-fluid d-flex justify-content-center">
      <div class="form-rest my-4 col-8">
        <div class="text-bg-secondary d-flex justify-content-between p-3">
          <span>Aun no has verificado tu identidad</span>
          <button class="btn btn-rounded btn-primary">Verificar mi identidad</button>
        </div>
      </div>
    </div>
    
    </div>
    <?php require_once($_SERVER ['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
    
    <!-- Imprime todas las publicaciones en la base de datos -->
    <?php 
      require_once("../components/publicaciones.php");
      echo renderPublicaciones();
    ?>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
  <script src="../js/validarReporte.js"></script>
  <script src="../js/postulacion.js"></script>
</body>
</html>