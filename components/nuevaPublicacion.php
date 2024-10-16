  <div class="d-flex justify-content-center">
            <div class="form-rest my-4 col-8"></div>
  </div>
  <div class="modal fade" id="modalCrearPublicacion" aria-hidden="true" aria-labelledby="modalCrearPublicacionLabel" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalCrearPublicacionLabel">Nueva Publicación</h1>
          <button type="button" class=" btn-close btn-cerrarFormularioPublicacion" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="/utils/ControlFormPublicacion.php" class="form-publicacion needs-validation FormularioAjax" novalidate method="post" id="formPublicacion" autocomplete="off" onsubmit="return validarPublicacion()">
            <div class="row">
              <div class="col-md-6 col-lg-3 mb-3">
                <input type="text" class="form-control " id="publicacion-titulo" name="titulo" placeholder="Titulo">
                <div class="invalid-feedback" id="invalid-titulo"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="publicacion-descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                <div class="invalid-feedback" id="invalid-descripcion"></div>
              </div>
            </div>

            
            <div class="row">
              <div class="col-md-6 col-lg-3">
                  <input type="number" step="0.01" class="form-control mb-3" id="publicacion-volumen" name="volumen" placeholder="Volumen">
                  <div class="invalid-feedback" id="invalid-volumen"></div>
              </div>
              <div class="col-md-6 col-lg-3">
                  <input type="number" step="0.01" class="form-control mb-3" id="publicacion-peso" name="peso" placeholder="Peso">
                  <div class="invalid-feedback" id="invalid-peso"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-lg-3">
                <input type="text" class="form-control mb-3" id="publicacion-origen" name="origen"  placeholder="Origen">
                <div class="invalid-feedback" id="invalid-origen"></div>
              </div>
              <div class="col-md-6 col-lg-3">
                <input type="text" class="form-control mb-3" id="publicacion-destino" name="destino"  placeholder="Destino">
                <div class="invalid-feedback" id="invalid-destino"></div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 col-lg-3">
                <input type="text" class="form-control mb-3" id="publicacion-recibe" name="recibe"  placeholder="Encargado de Recibir">
                <div class="invalid-feedback" id="invalid-recibe"> </div>
              </div>
              <div class="col-md-6 col-lg-3">
                <input type="tel" class="form-control mb-3" id="publicacion-contacto" name="contacto"  placeholder="Telefono de Contacto">
                <div class="invalid-feedback" id="invalid-contacto"> </div>
              </div>
            </div>

            <div class="row">
                <div id="add" class="col-12 mb-3">
                  <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                  <div class="custom-file-upload"> <h2 id="addPhoto">Cargar Foto ➕</h2> </div>
                  <select name="photosId[]" id="photosId" multiple hidden>
                  </select>
                  <div class="invalid-feedback" id="invalid-photo"></div>
                  <div id="photos"></div>
                  
                </div>
            </div>

            <input type="hidden" name="enviado">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
          <input type="submit" id="btn-enviar" form="formPublicacion" class="btn btn-amarillo"></input>
        </div>
      </div>
    </div>
  </div>

  <!--BOTON PARA ABRIR EL MODAL-->
  <div class="Container-fluid text-end">
    <div class="row justify-content-center">
        <div class="col-6 justify-content-center p-0">
            <div>
                <button class="btn mb-3" id="btn-crearPublicacion" data-bs-target="#modalCrearPublicacion" data-bs-toggle="modal">Crear Publicación</button>
            </div>
        </div>
    </div> 
  </div>  
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php"); ?>
</body>