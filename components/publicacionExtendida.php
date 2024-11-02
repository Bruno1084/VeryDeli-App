<?php
function renderPublicacionExtendida($idPublicacion, $username, $profileIcon, $date, $userLocation, $productDetail, $weight, $origin, $destination, $images) {
  ob_start();
  $contadorComentarios=0;
  $commentCache = [];
  ?>
    <div class='publicacionExtendida-container container-fluid shadow border border-dark-subtle rounded my-3'>
      <div class='row p-2 border-bottom' name='publicacion_A' id='publicacion-A'>
        <div class='d-flex col-6 mt-1 text-start lh-1'>
          <div>
            <img class='profilePicture' src='<?php echo $profileIcon; ?>' alt='user'>
          </div>
          <div>
            <p><?php echo $username; ?></p>
            <p><?php echo $userLocation; ?></p>
          </div>
        </div>
        <div class='col-6 mt-1 text-end lh-1 d-flex border d-flex justify-content-end'>
          <div>
            <p> <?php echo(date('H:i', strtotime($date)))?> </p>
            <p> <?php echo(date('d/m/Y', strtotime($date)))?> </p>
          </div>

          <div class="d-flex justify-content-center align-items-center">
            <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg">
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
    </div>
    <!--
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    -->

    <!-- POSTEAR COMENTARIO -->
    <?php echo renderPostComentario($username, "", $idPublicacion); ?>


    <!-- COMENTARIOS DE USUARIOS -->
    <div>
      <?php
      $comentarios = getAllComentariosFromPublicacion($idPublicacion);

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
          $contadorComentarios,
          $username,
          '',
          $c["comentario_fecha"],
          $c['comentario_mensaje']
        );
        $contadorComentarios++;
      }
      ?>
    </div>
  </div>


  <!-- MODAL POSTULARSE -->
  <div class="modal fade" id="modalPostularse<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalPostularseLabel<?php echo $idPublicacion ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalPostularseLabel<?php echo $idPublicacion ?>">Postularse</h1>
          <button type="button" class="btn-close" id="cerrarModalPostular<?php echo $idPublicacion ?>"  data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <button type="button" class="btn btn-outline-danger btn-md" data-bs-target="#modalReportar<?php echo $idPublicacion ?>" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"></path>
          </svg>Reportar
        </button>
      </div>

      <div class='row' id="carouselPublicacion">
        <div class='col-12'>
          <div id="carouselIndicators_A" class="carousel slide imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-start">
              <div class="carousel-indicators">
                <?php for($i=0;$i<sizeof($images);$i++) { ?>
                  <?php $a="'".($i+1)."'";
                   ?>
                  <button type="button" data-bs-target="#carouselIndicators_A" data-bs-slide-to=<?php echo $i?> <?php if($i==0)echo "class='active'";?> <?php if($i==0)echo "aria-current='true'";?> aria-label=<?php echo"'Slide ".($i+1)."'"; ?>></button>
                <?php } ?>
              </div>
              <div class="carousel-inner">
                <?php $i=0; foreach ($images as $imagen) {?>
                  <div class="carousel-item <?php if($i==0)echo"active";?>">
                      <img class='img u_photo img-fluid' src='<?php echo $imagen; ?>' alt='product-image'>
                  </div>
                <?php $i++;} ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_A" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_A" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
              </button>
          </div>
        </div>
      </div>
      <!-- MODAL POSTULARSE -->
      <div class="modal fade" id="modalPostularse<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalPostularseLabel<?php echo $idPublicacion ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content bg-modalPublicacion">
            <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
              <h1 class="modal-title fs-5" id="modalPostularseLabel<?php echo $idPublicacion ?>">Postularse</h1>
              <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <form action="/utils/postularse.php" class="form-publicacion form-postularse needs-validation FormularioAjax" novalidate method="post" id="formPostularse<?php echo $idPublicacion ?>" autocomplete="off" onsubmit="return validarPostulacion(<?php echo $idPublicacion?>)">
                <div class="row">
                  <div class="col-12">
                    <input type="number"  step="0.01" class="form-control mb-3" id="postulacion-monto<?php echo $idPublicacion ?>" name="monto" placeholder="Monto">
                    <div class="invalid-feedback" id="invalid-monto<?php echo $idPublicacion ?>"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <textarea style="height: 120px; max-height:120px" class="form-control" id="postulacion-descripcion<?php echo $idPublicacion ?>" name="descripcion" placeholder="Descripcion"></textarea>
                    <div class="invalid-feedback" id="invalid-pDescripcion<?php echo $idPublicacion ?>"></div>
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
  </div>


  <!-- MODAL REPORTAR -->
  <div class="modal fade" id="modalReportar<?php echo $idPublicacion ?>" aria-hidden="true" aria-labelledby="modalReportarLabel<?php echo $idPublicacion ?>" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalReportarLabel<?php echo $idPublicacion ?>">Reportar Publicacion</h1>
          <button type="button" class="btn-close" id="cerrarModalReportar<?php echo $idPublicacion ?>" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/reportar.php" class="form-publicacion form-reportar needs-validation FormularioAjax" method="post" id="formReportar<?php echo $idPublicacion ?>" novalidate>
            <div class="row">
              <div class="col-12">
                <select class="form-select" aria-label="Default select example" name="motivo" id="input-motivo<?php echo $idPublicacion ?>">
                  <option selected disabled>Seleccione un motivo...</option>
                  <option value="spam">Spam</option>
                  <option value="lenguaje inapropiado">Lenguaje inapropiado</option>
                  <option value="otro">Otro</option>
                </select>
                <div class="invalid-feedback" id="invalid-motivo<?php echo $idPublicacion ?>"></div>
              </div>
            </div>
            <div class="modal-body">
              <form action="/utils/reportar.php" class="form-publicacion form-reportar needs-validation FormularioAjax" method="post" id="formReportar<?php echo $idPublicacion ?>" novalidate  >
                <div class="row">
                  <div class="col-12">
                    <select class="form-select" aria-label="Default select example" name="motivo" id="input-motivo<?php echo $idPublicacion ?>">
                      <option selected disabled>Seleccione un motivo...</option>
                      <option value="spam">Spam</option>
                      <option value="lenguaje inapropiado">Lenguaje inapropiado</option>
                      <option value="otro">Otro</option>
                    </select>
                    <div class="invalid-feedback" id="invalid-motivo<?php echo $idPublicacion ?>"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <textarea style="height: 120px; max-height:120px" class="form-control" id="reporte-mensaje<?php echo $idPublicacion ?>" name="mensaje" placeholder="Mensaje"></textarea>
                    <div class="invalid-feedback" id="invalid-reporteMensaje<?php echo $idPublicacion ?>"></div>
                  </div>
                </div>
                <input type="hidden" name="reporteEnviado">
                <input type="hidden" name="publicacion-id" value="<?php echo $idPublicacion ?>">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" id="btn-enviar" form="formReportar<?php echo $idPublicacion ?>" class="btn btn-amarillo"></input>
            </div>
          </div>
        </div>
    </div>
      <div>
        <?php
          include_once ($_SERVER["DOCUMENT_ROOT"] . '/components/comentario.php');
          include_once ($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAllComentariosFromPublicacion.php");
          include_once ($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");

          $comentarios = getAllComentariosFromPublicacion($idPublicacion);

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
              $contadorComentarios,
              $username,
              '',
              $c['comentario_mensaje']
            );
            $contadorComentarios++;
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
}


