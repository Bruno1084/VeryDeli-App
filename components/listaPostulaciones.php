<?php
    function renderPostulaciones($idPublicacion){
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getAllPostulacionesFromPublicacion.php");
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getUsuario.php");
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getTransportistaPublicacion.php");
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getPublicacion.php");
        require_once($_SERVER["DOCUMENT_ROOT"]. "/database/conection.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
        $postulaciones = getAllPostulacionesFromPublicacion($idPublicacion);
        $db = new DB();
        $conexion = $db->getConnection();
        $publicacion = $conexion->query("SELECT * FROM publicaciones WHERE publicacion_id = $idPublicacion")->fetch(PDO::FETCH_ASSOC);
        ob_start();
    ?>
        <section>
        <div class="postulaciones container py-4">
          <div class="row">
            <div class="col-12">
              <h3 class="text-center mb-4">Postulaciones</h3>
              <?php if($postulaciones == false) {?>
                <p class="mb-1 fw-medium text-center"> Todavía nadie se ha postulado a tu publicación 😓 </p>
              
            </div>  
          </div>
          <?php } else {?>
          <?php 
          switch ($publicacion['publicacion_esActivo']):
            default:
            foreach($postulaciones as $postulacion) { 
              $usuario = getUsuario($postulacion['usuario_postulante']);
              switch($postulacion['postulacion_estado']){
                case '0':
                  $estado = 'Pendiente';
                  $bgEstado = 'btn btn-secondary';
                break;
                case '1';
                  $estado = 'Aceptada';
                  $bgEstado = 'btn btn-success';
                break;
                case '2';
                  $estado = 'Rechazada';
                  $bgEstado = 'btn btn-danger';
                break;
              }
          ?>
          <div class="row mb-3 align-items-center border p-2 rounded" id="postulacionP-<?= $nombreUsuario ?>">
            <div class="col-md-8">
              <h5 class="fw-bold mb-1"><?= $usuario['usuario_nombre'] ?></h5>
              <p class="mb-1">Precio: <span class="fw-bold">$<?= number_format($postulacion['postulacion_precio'], 0, ',', '.'); ?></span></p>
              <p class="text-muted mb-1"><?= $postulacion['postulacion_descr'] ?></p>
              <span class="mb-0"> <h5 class="fw-bold d-inline-block <?= $bgEstado ?>"><?= $estado ?></h5> </span>
            </div>
            <div class="col-md-4 text-md-end">
              <div class="btn-group">
                <button type="button" class="btn btn-success" title="Aceptar" data-id="<?= $postulacion['postulacion_id'] ?>" onclick="cambiarEstado(this, '1', <?=$idPublicacion?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"></path>
                  </svg>
                </button> 
                <button type="button" class="btn btn-danger" title="Rechazar" data-id="<?= $postulacion['postulacion_id'] ?>" onclick="cambiarEstado(this, '2',  <?=$idPublicacion?>)">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          <?php } break; 
            case '2' : 
            $postulacion = getTransportistaPublicacion($idPublicacion);
            $usuario = getUsuario($postulacion['usuario_postulante']);
            ?>
            <div class="row mb-3 align-items-center border p-2 rounded" id="postulacionP-<?= $usuario['usuario_nombre'] ?>">
              <div class="col-md-8">
                  <h5 class="fw-bold mb-1"><?= $usuario['usuario_nombre'] ?></h5>
                  <p class="mb-1">Precio: <span class="fw-bold">$<?= number_format($postulacion['postulacion_precio'], 0, ',', '.'); ?></span></p>
                  <p class="text-muted mb-1"><?= $postulacion['postulacion_descr'] ?></p>
                  <span class="mb-0"><h5 class="fw-bold d-inline-block btn btn-success">Aceptada</h5></span>
              </div>
              <div class="col-md-4 text-md-end">
                  <div class="btn-group">
                      <button type="button" class="btn btn-danger" title="Cancelar" data-id="<?= $postulacion['postulacion_id'] ?>" onclick="cancelarTransportista(this, '2', <?=$idPublicacion?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                          <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                          <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                        </svg>
                      </button>
                  </div>
              </div>
            </div>
<?php
    break;
    case '3':
    $count=0;
    $postulacion = getTransportistaPublicacion($idPublicacion);
    $usuario = getUsuario($postulacion['usuario_postulante']);
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getCalificacionesFromPublicacion.php');
    $calificaciones = getCalificacionesFromPublicacion($idPublicacion);
    $count = 0;
    if(!empty($calificaciones)){
      $count = 0;
      foreach($calificaciones as $calificacion){
        if($calificacion['usuario_calificador'] == $_SESSION['id']){
          $count += 1;
        }
      }
    } 
    if($count == 0){
      include_once($_SERVER['DOCUMENT_ROOT'] . '/components/calificarTransportista.php');
      renderCalificarTransportista($usuario, $postulacion, $idPublicacion);
    } else{
      //Logica para mostrar las calificaciones.
      echo 'Ya has calificado esta publicacion';
    }
    
?>

<?php 
  break;
  endswitch;
  }
?>
  </div>
    </section>
<?php
    return ob_get_clean();
  }
?>
