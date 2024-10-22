<?php
function renderPublicacionAcotada ($idPublicacion, $username, $profileIcon, $date, $productDetail) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/getAllImagenesFromPublicacion.php');
  ob_start();

  $imagenes = getAllImagenesFromPublicacion($idPublicacion);
  $commentCache = [];
?>
  <div class='publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3'>
    <div class='row p-2 border-bottom' name='publicacion_D' id='publicacion-N_AD'>
      <div class='d-flex col-6 mt-1 text-start lh-1'>
        <div>
          <img class='profilePicture' src='<?php echo $profileIcon; ?>' alt='user'>
        </div>
        <div>
          <p><?php echo $username; ?></p>
          <p><?php echo $userLocation; ?></p>
        </div>
      </div>
      <div class='col-6 mt-1 text-end lh-1'>
        <div>
          <p> <?php echo (date('H:i', strtotime($date))) ?> </p>
          <p> <?php echo (date('d/m/Y', strtotime($date))) ?> </p>
        </div>
      </div>
    </div>

  </div>

<?php
  return ob_get_clean();
};
?>