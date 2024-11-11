<?php

function renderPublicacioVerificar ($idPublicacion, $username, $profileIcon, $date, $userLocation, $productDetail, $weight, $origin, $destination, $images) {
  $contadorComentarios = 0;
  $commentCache = [];
  include_once($_SERVER["DOCUMENT_ROOT"] . '/components/postComentario.php');
  include_once($_SERVER["DOCUMENT_ROOT"] . '/components/comentario.php');
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAllComentariosFromPublicacion.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

  ob_start();
?>
  <div class='publicacionExtendida-container container-fluid shadow border border-dark-subtle rounded my-3'>
    <div class='row p-2' name='publicacion_A' id='publicacion-A'>
      <div class="cabeceraPublicacion d-flex col-12 justify-content-center datosUsuario border-bottom align-items-center">
        <div class='d-flex col-6 mt-1 text-start lh-1'>
          
          <?php echo obtenerFoto($profileIcon);?>
          
          <div>
            <p><?php echo $username; ?></p>
            <p><?php echo $userLocation; ?></p>
          </div>
        </div>
        
        <div class='col-6 mt-1 text-end lh-1 d-flex d-flex justify-content-end'>
          <div>
            <p> <?php echo (date('H:i', strtotime($date))) ?> </p>
            <p> <?php echo (date('d/m/Y', strtotime($date))) ?> </p>
          </div>

          <?php 
              require_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getAutorPublicacion.php");
            ?>
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

      <p class='my-4 d-flex justify-content-between align-items-center'>
      <div>
        <button type='button' class='btn btn-gris btn-md' data-bs-target="#modalPostularse<?php echo $idPublicacion ?>" data-bs-toggle="modal">Verificar</button>
      </div>
        <button type='button' class='btn btn-gris btn-md' data-bs-target="#modalPostularse<?php echo $idPublicacion ?>" data-bs-toggle="modal">Rechazar</button>
      </div>

      <div class='row' id="carouselPublicacion">
        <div class='col-12'>
          <div id="carouselIndicators_A" class="carousel slide imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-start">
            <div class="carousel-indicators">
              <?php for ($i = 0; $i < sizeof($images); $i++) { ?>
                <?php $a = "'" . ($i + 1) . "'";
                ?>
                <button type="button" data-bs-target="#carouselIndicators_A" data-bs-slide-to=<?php echo $i ?> <?php if ($i == 0) echo "class='active'"; ?> <?php if ($i == 0) echo "aria-current='true'"; ?> aria-label=<?php echo "'Slide " . ($i + 1) . "'"; ?>></button>
              <?php } ?>
            </div>
            <div class="carousel-inner">
              <?php $i = 0;
              foreach ($images as $imagen) { ?>
                <div class="carousel-item <?php if ($i == 0) echo "active"; ?>">
                  <img class='img u_photo img-fluid' src='<?php echo $imagen; ?>' alt='product-image'>
                </div>
              <?php $i++;
              } ?>
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
    <?php echo renderPostComentario($idPublicacion); ?>


      <!-- COMENTARIOS DE USUARIOS -->
      <div>
        <?php
        $comentarios = getAllComentariosFromPublicacion($idPublicacion);

        foreach ($comentarios as $c) {

          $foto=array("foto"=>$c["usuario_fotoPerfil"],"marco"=>$c["usuario_marcoFoto"]);
          
          echo renderComentario(
            $contadorComentarios,
            $c["comentario_id"],
            $c["usuario_usuario"],
            $foto,
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
        <div class="modal-body">
          <form action="/utils/postularse.php" class="form-publicacion form-postularse needs-validation FormularioAjax" novalidate method="post" id="formPostularse<?php echo $idPublicacion ?>" autocomplete="off" onsubmit="return validarPostulacion(<?php echo $idPublicacion ?>)">
            <div class="row">
              <div class="col-12">
                <input type="number" step="0.01" class="form-control mb-3" id="postulacion-monto<?php echo $idPublicacion ?>" name="monto" placeholder="Monto">
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



  </div>
<?php
  return ob_get_clean();
}



