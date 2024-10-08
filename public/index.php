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
  <?php require_once("../components/publicaciones.php");?>
  <div>
    <?php
    if(isset($_SESSION['nombre'])){
      echo('Bienvenido '.$_SESSION['nombre'].' '.$_SESSION['apellido'].'!');
    }
    ?>
  </div>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
