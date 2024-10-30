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
              <div class="col-12 mb-5">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="publicacion-descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                <div class="invalid-feedback" id="invalid-descripcion"></div>
              </div>
            </div>

            
            <div class="row cuerpo_medio mb-4">

              <div class="col-6" id="lado">

                  <div class="col-md-6">
                    <div class="col-10">
                      <input type="number" step="0.01" class="form-control" id="publicacion-volumen" name="volumen"  placeholder="Volumen">
                      <div class="invalid-feedback" id="invalid-volumen"></div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="col-10">
                      <input type="number" step="0.01" class="form-control" id="publicacion-peso" name="peso"  placeholder="Peso">
                      <div class="invalid-feedback" id="invalid-peso"></div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <h2>Origen:</h2>
                      <div class="col-10">
                          <input type="text" class="form-control" id="publicacion-origen-barrio" name="origen_barrio" placeholder="Barrio">
                          <div class="invalid-feedback" id="invalid-origen-barrio"></div>
                      </div>
                      <div class="col-10">
                          <input type="text" class="form-control" id="publicacion-origen-manzana" name="origen_manzana-piso" placeholder="Manzana/Piso">
                          <div class="invalid-feedback" id="invalid-origen-manzana"></div>
                      </div>
                      <div class="col-10">
                          <input type="text" class="form-control" id="publicacion-origen-casa" name="origen_casa-depto" placeholder="Casa/Depto">
                          <div class="invalid-feedback" id="invalid-origen-casa"></div>
                      </div>
                      <input type="text" name="origen_coordenadas" id="coordsOrigen" hidden>
                  </div>

                  <div class="col-md-6">
                      <h2>Destino:</h2>
                      <div class="col-10">
                        <input type="text" class="form-control" id="publicacion-destino-barrio" name="destino_barrio" placeholder="Barrio">
                        <div class="invalid-feedback" id="invalid-destino-barrio"></div>
                      </div>
                      <div class="col-10">
                        <input type="text" class="form-control" id="publicacion-destino-manzana" name="destino_manzana-piso" placeholder="Manzana/Piso">
                        <div class="invalid-feedback" id="invalid-destino-manzana"></div>
                      </div>
                      <div class="col-10">
                        <input type="text" class="form-control" id="publicacion-destino-casa" name="destino_casa-depto" placeholder="Casa/Depto">
                        <div class="invalid-feedback" id="invalid-destino-casa"></div>
                      </div>
                      <input type="text" name="destino_coordenadas" id="coordsDestino" hidden>
                  </div>

                  <div class="col-md-6">
                    <div class="col-10">
                      <input type="text" class="form-control" id="publicacion-recibe" name="recibe"  placeholder="Encargado de Recibir">
                      <div class="invalid-feedback" id="invalid-recibe"> </div>
                    </div>
                  </div>
    
                  <div class="col-md-6">
                    <div class="col-10">
                      <input type="tel" class="form-control" id="publicacion-contacto" name="contacto"  placeholder="Telefono de Contacto">
                      <div class="invalid-feedback" id="invalid-contacto"> </div>
                      </div>
                  </div>

              </div>

              <div class="col-6 divMapa_Boton">
                  <div id="map">
                  </div>
                  <div class="col-12" style="height: 21px;"><div class="invalid-feedback" id="invalid-map"></div></div>
              </div>

            
            </div>
            
            <div class="row">
              <div id="add" class="col-12 mb-3">
                <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                <div class="custom-file-upload mb-2"> <h2 id="addPhoto">Cargar Fotos ➕</h2> </div>
                <div class="invalid-feedback" id="invalid-photos"></div>
                <select name="photosId[]" id="photosId" multiple hidden></select>
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
    <div class="justify-content-center div-crearPublicacion">
        <div class="justify-content-center p-0">
            <div>
                <button class="btn mb-3" id="btn-crearPublicacion" data-bs-target="#modalCrearPublicacion" data-bs-toggle="modal">Crear Publicación</button>
            </div>
        </div>
    </div> 
  </div>  
  


  <?php require_once("../components/JS.php"); ?>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script src="/js/inputFotos.js"></script>
  <script src="../js/ubicacionEnvio.js"></script>
  <script src="../js/formularioPublicaciones.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="/js/ajax.js"></script>
</body>