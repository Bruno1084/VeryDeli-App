<?php
function obtenerFoto($fYm){
  if($fYm["foto"]==0 && $fYm["marco"]==0){
    return "<div class='defaultPicture'><img src='../assets/user.png' alt='user'></div>";
  }
  elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
    return "<div class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></div>";
  }
  elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
    return '<div class="profilePicture">
            <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
            <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
            </div>';
  }
  else{
    return '<div class="profilePicture">
            <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
            <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
            </div>';
  }
}
function renderPublicacionExtendida ($idPublicacion, $username, $profileIcon, $date, $userLocation, $productDetail, $weight, $origin, $destination, $images, $denunciada=false) {
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
              $autor = getAutorPublicacion($idPublicacion);
              if($_SESSION['id'] == $autor['usuario_autor'] && $denunciada==false){
                echo '
                <div class="dropdown publicacionExtendida-menuButton-container">
                  <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="#" onclick="finalizarPublicacion(<?= $idPublicacion ?>)">Eliminar publicacion</a></li>
                  </ul>
                </div>';
              }
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

      <div class='my-4 d-flex justify-content-between align-items-center'>
        <?php  
        if($denunciada==false){?>
      <div><?php
          if($_SESSION["id"] != $autor["usuario_autor"]){
            $db = new DB();
            $conexion = $db->getConnection();
            $db = null;
            $publicacion = $conexion->query("SELECT publicaciones.publicacion_esActivo FROM publicaciones WHERE publicacion_id = $idPublicacion")->fetch(PDO::FETCH_ASSOC); 
            if ($publicacion['publicacion_esActivo'] != 3){ ?>
            <button type='button' class='btn btn-gris btn-md' data-bs-target="#modalPostularse<?php echo $idPublicacion ?>" data-bs-toggle="modal">Postularse</button>
            <?php } else {
              require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getTransportistaPublicacion.php");
              require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getPostRatingUsuario.php');
              $postulacion = getTransportistaPublicacion($idPublicacion);
              if($_SESSION['id'] == $postulacion['usuario_postulante'] AND getPostRatingUsuario($idPublicacion, $postulacion['usuario_postulante']) == false) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/components/calificarUsuario.php');
                renderCalificarUsuario($idPublicacion);
              }
            }
          $conexion = null;
          $publicacion = null;
          }else{
            echo '<button type="button" class="btn btn-gris btn-md" href="#" onclick="finalizarPublicacion(<?= $idPublicacion ?>)">Finalizar publicacion</button>';
          }?>
        </div>
  <?php  }
        ?>
      <?php if($denunciada==false){?>
        <button type="button" class="btn btn-outline-danger btn-md" data-bs-target="#modalReportar<?php echo $idPublicacion ?>" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"></path>
          </svg>Reportar
        </button>
        <?php
          }
          else{?>
          <button type="button" class="btn btn-outline-danger btn-md" data-bs-target="#modalReportar<?php echo $idPublicacion ?>" data-bs-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
              <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"></path>
            </svg>Rechazar
          </button>
          <button type="button" class="btn btn-outline-danger btn-md" data-bs-target="#modalReportar<?php echo $idPublicacion ?>" data-bs-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag" viewBox="0 0 16 16">
              <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"></path>
            </svg>Aceptar
          </button>
          <?php }
      ?>
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

    <!-- POSTEAR COMENTARIO -->
    <?php 
      if($denunciada==false){
        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
        $username = getUsuario($_SESSION['id'])['usuario_usuario'];
        $fYm=array("foto"=>$_SESSION["fotoPerfil"],"marco"=>$_SESSION["marcoFoto"]);
        echo renderPostComentario($username, $fYm, $idPublicacion); 
      }
    ?>


      <!-- COMENTARIOS DE USUARIOS -->
      <div class="comentarios-container">
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
            $c['comentario_mensaje'],
            $c["usuario_id"],
            $autor["usuario_autor"]
          );
          $contadorComentarios++;
        }
        ?>
      </div>
    </div>

  <?php if($denunciada==false){
  ?>

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

  <?php
  }?>



  </div>
<?php
  return ob_get_clean();
}