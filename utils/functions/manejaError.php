<?php

function manejarError($mensaje) {
  echo '
  <div class="text-bg-danger p-3">
      <strong>¡Ocurrió un error inesperado!</strong><br>
      ' . $mensaje . '
  </div>';
  exit();
}
?>