<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getAutorPublicacion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
function renderCalificarUsuario($idPublicacion){ ?>
  <?php $usuario = getAutorPublicacion($idPublicacion) ?>
  <button type='button' class='btn btn-gris btn-md' title="Calificar Usuario" data-bs-target="#modalCalificar" data-bs-toggle="modal">Calificar Usuario</button>

  <div class="modal fade" id="modalCalificar" aria-hidden="true" aria-labelledby="modalCalificarLabel" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalCalificarLabel">Calificar Usuario</h1>
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
            <input type="hidden" name="calificado" value="<?= $usuario['usuario_autor']?>">
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