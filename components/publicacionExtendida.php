<?php
function renderPublicacionExtendida($idPublicacion, $username, $profileIcon, $userLocation, $productDetail, $weight, $origin, $destination, $images) {

  ob_start();

  $commentCache = [];
  ?>
    <div class='publicacionExtendida-container container-fluid shadow border border-dark-subtle rounded my-3'>
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
            <p>12:30</p>
            <p>12703/20</p>
          </div>
        </div>
      </div>

      <div class='my-3'>
        <div>
          <div>
            <p class='text-start fs-5 lh-1'>Detalles del producto:</p>
          </div>
          <div>
            <p class='publicacion-descripcion'><?php echo $productDetail; ?></p>
          </div>
        </div>

        <div>
          <div class='text-start lh-1'>
            <p class='fs-5'>Peso:</p>
            <p><?php echo $weight; ?></p>
          </div>
          <div class='text-start lh-1'>
            <p class='fs-5'>Origen:</p>
            <p><?php echo $origin; ?></p>
          </div>
          <div class='text-start lh-1'>
            <p class='fs-5'>Destino:</p>
            <p><?php echo $destination; ?></p>
          </div>
        </div>
      </div>

      <div class='my-4'>
        <div class='d-flex justify-content-start'>
          <button type='button' class='btn btn-gris btn-md'>Postularse</button>
        </div>
      </div>

      <div class='row'>
        <div class='col-12'>
          <div class='border border-dark-3'>
            <img class='img u_photo w-50 h-50' src='<?php echo $images; ?>' alt='product-image'>
          </div>
        </div>
      </div>

      <div>
        <?php
          include_once '../components/post-comentario.php';
          echo renderPostComentario($username, "");
        ?>
      </div>

      <div>
        <?php
          include_once '../components/comentario.php';
          $db = new DB();

          $comentarios = $db->getAllComentariosFromPublicacion($idPublicacion);

          foreach ($comentarios as $c) {
            $autorId = $c['usuario_id'];

            if (isset($commentCache[$autorId])) {
              $user = $commentCache[$autorId];
            } else {
              $user = $db->getUsuario($autorId);
              $commentCache[$autorId] = $user;
            };

            $username = $user["usuario_nombre"] . " " . $user["usuario_apellido"];

            echo renderComentario(
              $username,
              '',
              $c['comentario_mensaje']
            );

          }
        ?>
      </div>
    </div>
  <?php

return ob_get_clean();
};
?>