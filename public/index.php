<?php require_once('../utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <?php include_once($_SERVER ['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
  
  <!-- Imprime todas las publicaciones en la base de datos -->
  <?php 
    require_once("../components/publicaciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAllPublicaciones.php");
    $publicaciones = getAllPublicaciones();
    
    echo renderPublicaciones($publicaciones);
  ?>
  <div>
    <?php
    if(isset($_SESSION['user']) && !empty($_SESSION['user']['usuario_nombre'])){
      echo('Bienvenido '.$_SESSION['user']['usuario_nombre'].' '.$_SESSION['user']['usuario_apellido'].'!');
    }
    ?>
  </div>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
