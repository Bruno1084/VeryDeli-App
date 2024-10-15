<?php require_once('../utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php") ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <?php include_once($_SERVER ['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
  
  <!-- Imprime todas las publicaciones en la base de datos -->
  <?php 
    require_once("../components/publicaciones.php");
    $db = new DB();
    $publicaciones = $db->getAllPublicaciones();
    echo renderPublicaciones($publicaciones);
  ?>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
