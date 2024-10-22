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
<body style="color: D9D9D9;">
  <?php require_once("../components/Header.php");?>
  <?php include_once($_SERVER ['DOCUMENT_ROOT'].'/components/nuevaPublicacion.php') ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicaciones.php")?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllUsuarios.php")?>
  <div>
    <?php
    if(isset($_SESSION['nombre'])){
      echo('Bienvenido '.$_SESSION['nombre'].' '.$_SESSION['apellido'].'!');
    }
    ?>
    </div>
    <?php include_once($_SERVER ['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
    
    <!-- Imprime todas las publicaciones en la base de datos -->
    <?php 
      require_once("../components/publicaciones.php");
      echo renderPublicaciones();
    ?>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
  <script src="/js/validaciones.js"></script>
  <script src="/js/postulacion.js"></script>
</body>
</html>
