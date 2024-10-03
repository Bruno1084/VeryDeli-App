<?php
function manejarError ($titulo, $mensaje) {
  echo '
  <div class="text-bg-danger p-3">
      <strong>¡'.$titulo.'!</strong><br>
      ' . $mensaje . '
  </div>';
  exit();
};
?>