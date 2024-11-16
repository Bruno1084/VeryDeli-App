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
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/denunciasPendientes.php")?>
        <?php require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllUsuarios.php")?>

        <!-- Imprime todas las Denuncias activas en la base de datos -->

        <?php 
        echo renderDenunciasPendientes();
        ?>
        
        <?php
        }
    ?>
  </div>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/Footer.php"); ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/JS.php"); ?>
  
  
  
</body>
</html>