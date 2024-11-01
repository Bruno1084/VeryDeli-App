<?php require_once('../utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php")?>
  <link rel="stylesheet" href="../css/ubicacionEnvio.css">
  <?php require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once($_SERVER['DOCUMENT_ROOT']."/components/Header.php");?>
  <?php require_once($_SERVER ['DOCUMENT_ROOT'].'/components/nuevaPublicacion.php') ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicaciones.php")?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllUsuarios.php")?>
  <div>
    <?php
    if(isset($_SESSION['id'])){
      echo('Bienvenido '.$_SESSION['id'].'!');
    }
    ?>
    <div class="container-fluid col-lg-7 mx-auto px-0">
      <div class="form-rest my-4">
        <div class="text-bg-secondary d-flex justify-content-between align-items-center p-3">
          <span>Aún no has verificado tu identidad</span>
          <button class="btn btn-primary" id="btn-verificarUsuario" data-bs-target="#modalVerificar" data-bs-toggle="modal">Verificar mi identidad</button>
        </div>
      </div>
    </div>
    <div>
      <div class="container container-fluid d-flex justify-content-center">
        <div class="form-rest my-4 col-8">
            <div class="text-bg-secondary d-flex justify-content-between p-3">
              <span>Aun no has verificado tu identidad</span>
              <button class="btn btn-rounded btn-primary">Verificar mi identidad</button>
            </div>
        </div>
      </div>
    </div>

    <!-- Modal verificar -->
    <div class="modal fade" id="modalVerificar" aria-hidden="true" aria-labelledby="modalVerificarLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content bg-modalPublicacion">
            <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
              <h1 class="modal-title fs-5" id="modalVerificarLabel">Verificar identidad</h1>
              <button type="button" class=" btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <form action="/utils/verificar.php" class="form-publicacion form-verificar needs-validation FormularioAjax" method="post" id="formVerificar" novalidate  >
                <div class="row">
                  <div class="col-12 mb-1 p-3">
                    <select class="form-select" aria-label="Default select example" name="tipoDoc" id="input-tipo-doc">
                      <option selected disabled>Seleccione un tipo de documentacion...</option>
                      <option value="1">DNI</option>
                      <option value="2">Pasaporte</option>
                      <option value="2">Cedula de identidad</option>
                      <option value="3">Otro</option>
                    </select>
                  </div>

                  <div class="col-12 row mb-1 p-3">
                    <div class="col-6">
                      <div id="add" class="col-6">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                        <div class="custom-file-upload"> <h2 id="addPhoto">Frente</h2> </div>
                        <div class="invalid-feedback" id="invalid-photos"></div>
                        <select name="photosIdFrenteDoc[]" id="photosId" multiple hidden></select>
                        <div id="photos"></div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div id="add" class="col-6">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                        <div class="custom-file-upload"> <h2 id="addPhoto">Dorso</h2> </div>
                        <div class="invalid-feedback" id="invalid-photos"></div>
                        <select name="photosIdDorsoDoc[]" id="photosId" multiple hidden></select>
                        <div id="photos"></div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mb-1 p-3">
                    <select class="form-select" aria-label="Default select example" name="tipoBol" id="input-tipo-bol">
                      <option selected disabled>Seleccione un tipo de boleta...</option>
                      <option value="1">Factura de Servicios</option>
                      <option value="2">Boleta de impuestos</option>
                      <option value="3">Resumen de tarjeta de crédito o cuenta bancaria</option>
                      <option value="4">Contrato de alquiler</option>
                      <option value="5">Otro</option>
                    </select>
                  </div>

                  <div class="col-12 row mb-1 p-3">
                    <div class="col-6">
                      <div id="add" class="col-6">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                        <div class="custom-file-upload"> <h2 id="addPhoto">Frente</h2> </div>
                        <div class="invalid-feedback" id="invalid-photos"></div>
                        <select name="photosIdFrenteBol[]" id="photosId" multiple hidden></select>
                        <div id="photos"></div>
                      </div>
                    </div>

                    <div class="col-6">
                      <div id="add" class="col-6">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto[]" id="addNewPhoto" onchange="preVisual(event)" multiple/>
                        <div class="custom-file-upload"> <h2 id="addPhoto">Dorso</h2> </div>
                        <div class="invalid-feedback" id="invalid-photos"></div>
                        <select name="photosIdDorsoBol[]" id="photosId" multiple hidden></select>
                        <div id="photos"></div>
                      </div>
                    </div>
                  </div>

                </div>
                <input type="hidden" name="verificacionEnviada">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-morado mb-2" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" id="btn-enviar" form="formVerificar" class="btn btn-amarillo"></input>
            </div>
          </div>
        </div>
    
    </div>
    <?php require_once($_SERVER ['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
    
    <!-- Imprime todas las publicaciones activas en la base de datos -->
    <?php 
      require_once("../components/publicaciones.php");
      echo renderPublicaciones();
    ?>
  <?php require_once("../components/Footer.php"); ?>
  <?php require_once("../components/JS.php"); ?>
  <script src="../js/validarReporte.js"></script>
  <script src="../js/postulacion.js"></script>
  <script src="../js/verificarUsuario.js"></script>
</body>
</html>