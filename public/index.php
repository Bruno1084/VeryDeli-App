<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("../components/head.php") ?>
</head>
<body>
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
          echo "<li>" . $usuario['nombre'] . " - " . $usuario['email'] . "</li>";
        }
        echo "</ul>";
      } else {
        echo "No hay usuarios disponibles.";
      }
    ?>
  </div>
</body>
</html>
