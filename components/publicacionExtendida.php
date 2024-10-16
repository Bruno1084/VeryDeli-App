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
          <button type='button' class='btn btn-gris btn-md'  data-bs-target="#modalPostularse<?php echo $idPublicacion ?>" data-bs-toggle="modal">Postularse</button>
        </div>
      </div>

      <div class='row'>
        <div class='col-12'>
          <div class='border border-dark-3'>
            <img class='img u_photo w-50 h-50' src='<?php echo $images; ?>' alt='product-image'>
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalPostularse<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalPostularseLabel<?php echo $idPublicacion ?>" tabindex="-1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content bg-modalPublicacion">
            <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
              <h1 class="modal-title fs-5" id="modalPostularseLabel<?php echo $idPublicacion ?>">Postularse</h1>
              <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <form action="/utils/postularse.php" class="form-publicacion form-postularse needs-validation FormularioAjax" novalidate method="post" id="formPostularse<?php echo $idPublicacion ?>" autocomplete="off" onsubmit="return validarPostulacion()">
                <div class="row">
                  <div class="col-12">
                    <input type="number"  step="0.01" class="form-control mb-3" id="postulacion-monto" name="monto" placeholder="Monto">
                    <div class="invalid-feedback" id="invalid-monto"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <textarea style="height: 120px; max-height:120px" class="form-control" id="postulacion-descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                    <div class="invalid-feedback" id="invalid-pDescripcion"></div>
                  </div>
                </div>
                <input type="hidden" name="enviado">
                <input type="hidden" name="publicacion-id" value="<?php echo $idPublicacion ?>">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" id="btn-enviar" form="formPostularse<?php echo $idPublicacion ?>" class="btn btn-amarillo"></input>
            </div>
          </div>
        </div>
    </div>

      <div>
        <?php
          include_once '../components/comentario.php';
          include_once ($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAllComentariosFromPublicacion.php");
          include_once ($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");

          $db = new DB();

          $comentarios = getAllImagenesFromPublicacion($idPublicacion);

          foreach ($comentarios as $c) {
            $autorId = $c['usuario_id'];

            if (isset($commentCache[$autorId])) {
              $user = $commentCache[$autorId];
            } else {
              $user = getUsuario($autorId);
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

      <div>
        <?php
          include_once '../components/post-comentario.php';
          echo renderPostComentario($username, "", $idPublicacion);
        ?>
      </div>
    </div>
  <?php
  
return ob_get_clean();
};
?>

<script src="/js/postulacion.js"></script>