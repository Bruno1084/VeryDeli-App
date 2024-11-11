<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
function renderCalificarTransportista($usuario, $postulacion, $idPublicacion){ ?>
  <div class="row mb-3 align-items-center border p-2 rounded" id="postulacionP-<?= $usuario['usuario_nombre'] ?>">
    <div class="col-md-8">
      <h5 class="fw-bold mb-1"><?= $usuario['usuario_nombre'] ?></h5>
      <p class="mb-1">Precio: <span class="fw-bold">$<?= number_format($postulacion['postulacion_precio'], 0, ',', '.'); ?></span></p>
      <p class="text-muted mb-1"><?= $postulacion['postulacion_descr'] ?></p>
      <span class="mb-0"><h5 class="fw-bold d-inline-block btn btn-success">Aceptada</h5></span>
    </div>
    
    <div class="col-md-4 text-md-end">
      <div class="btn-group">
        <button type="button" class="btn btn-warning" title="Calificar" data-bs-target="#modalCalificar" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modalCalificar" aria-hidden="true" aria-labelledby="modalCalificarLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalCalificarLabel">Calificar Transportista</h1>
          <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/calificar.php" class="form-publicacion form-calificar needs-validation FormularioAjax" method="post" id="formCalificarTransportista" novalidate>
            <div class="row">
              <div class="col-12">
                <select class="form-select" aria-label="Default select example" name="puntaje" id="inputPuntaje">
                  <option selected disabled>Seleccione un puntaje</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <div class="invalid-feedback" id="invalid-puntaje"></div>
              </div>
            </div>

            <input type="hidden" name="calificador" value="<?= $_SESSION['id']?>">
            <input type="hidden" name="calificado" value="<?= $usuario['usuario_id']?>">
            <input type="hidden" name="publicacion-id" value="<?php echo $idPublicacion ?>">
            <input type="hidden" name="calificacionEnviada">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" id="btn-enviar" form="formCalificarTransportista" class="btn btn-amarillo"></input>
        </div>
      </div>
    </div>
  </div>
<?php  } ?>