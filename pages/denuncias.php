<?php require_once($_SERVER["DOCUMENT_ROOT"].'/utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <link rel="stylesheet" href="../css/publicacionAcotada.css">
  <?php require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Header.php");?>
  <div class="primerDivBody">
    <?php
        if($_SESSION["esAdmin"]==1){
    ?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicacionesDenunciadas.php")?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllUsuarios.php")?>

        <!-- Imprime todas las publicaciones Denunciadas y activas en la base de datos -->

        <?php 
        echo renderPublicacionesDenunciadas();
        ?>
        
        <?php
        }
    ?>
  </div>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Footer.php"); ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php"); ?>
  <?php
    if($_SESSION["esVerificado"]==0) echo '<script src="../js/verificarUsuario.js"></script>';  
  ?>
  <script src="../js/validarReporte.js"></script>
  <script src="../js/postulacion.js"></script>
</body>
</html>