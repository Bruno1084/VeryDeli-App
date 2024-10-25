<?php
function renderPublicacionAcotada ($idPublicacion, $userLocation, $username, $profileIcon, $date, $productDetail) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/getAllImagenesFromPublicacion.php');
  ob_start();

  $images = getAllImagenesFromPublicacion($idPublicacion);
?>
<div class='publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3'>
  <a class="text-reset text-decoration-none" href='<?php echo "/pages/publicacion.php?id=". $idPublicacion ?>'>
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

    <div >
      <div>
        <p class="my-3 text-start"><?php echo $productDetail ?></p>
      </div>

      <div class='imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-center'>
        <img class='img u_photo img-fluid' src='<?php echo $images[0]['imagen_url'] ?>' alt='product-image'>
      </div>
    </div>
  </a>
</div>
<?php
  return ob_get_clean();
};
?>