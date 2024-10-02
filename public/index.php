<?php
  require "../vendor/autoload.php";
  $dotenv = Dotenv\Dotenv::createImmutable("../");
  $dotenv->load();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("../components/head.php") ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <h1>Esto debería mostrar los usuarios</h1>
  
  <div>
    <?php
      require '../utils/getAllUsuarios.php';

      // Fetch the users
      $usuarios = getAllUsuarios();

      // Check if there are any users
      if (!empty($usuarios)) {
        echo "<ul>";
        // Loop through the users and display them
        foreach ($usuarios as $usuario) {
          echo "<li>" . $usuario['usuario_nombre'] . " - " . $usuario['usuario_correo'] . "</li>";
        }
        echo "</ul>";
      } else {
        echo "No hay usuarios disponibles.";
      }
    ?>
  </div>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
