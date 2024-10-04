<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php");?>
  <h1 class="text-center">Esto debería mostrar los usuarios</h1>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/public/formulario-imagenes/pantalla.php") ?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/publicaciones.php");?>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php");?>
  <!-- <div>
    <?php
      require $_SERVER['DOCUMENT_ROOT'] . '/utils/getAllUsuarios.php';

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
    !-->
  </div>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php"); ?>
</body>
</html>