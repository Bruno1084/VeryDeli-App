<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("../components/head.php");
    include "../database/conection.php";
    $DB = new DB();
  ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <?php 
    include "../components/publicaciones.php";
    $publicaciones = $DB->getAllPublicaciones();

    echo renderPublicaciones($publicaciones);

    // include "../components/publicacionExtendida.php";
    // echo renderPublicacionExtendida("username", "profileIcon", "userLocation", "productDetail", "weight", "origin", "destination", "images");
  ?>
  <?php require_once("../components/Footer.php");?>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
