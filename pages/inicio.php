<?php require_once($_SERVER["DOCUMENT_ROOT"] . '/utils/functions/startSession.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
  <link rel="stylesheet" href="../css/ubicacionEnvio.css">
  <link rel="stylesheet" href="../css/publicacionAcotada.css">
  <?php
  if ($_SESSION["esVerificado"] == 0) echo '<link rel="stylesheet" href="../css/verificacion.css">';
  ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . '/database/conection.php'); ?>
  <title>Very Deli</title>
</head>

<body>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/Header.php"); ?>

  <div class="primerDivBody">

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/publicaciones.php") ?>
    <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getAllUsuarios.php") ?>
    <?php
    if ($_SESSION["esVerificado"] == 0) {
    ?>
      <div>
        <div class="container container-fluid d-flex justify-content-center">
          <div class="form-rest col-12 col-md-8 my-4">
            <div class="text-bg-secondary alert alert-secondary d-flex justify-content-between align-items-center p-3">
              <span>Aún no has verificado tu identidad</span>
              <button class="btn btn-primary" id="btn-verificarUsuario" data-bs-target="#modalVerificar" data-bs-toggle="modal">
                Verificar mi identidad
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal verificar -->
      <div class="modal fade" id="modalVerificar" aria-hidden="true" aria-labelledby="modalVerificarLabel" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content bg-modalPublicacion">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalVerificarLabel">Verificar identidad</h1>
              <button type="button" id="cerrarModVerify" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
              <form action="/utils/verificar.php" class="form-publicacion form-verificar needs-validation FormularioAjax" method="post" id="formVerificar" novalidate>
                <div class="row">
                  <div class="col-md-12 mb-3 d-flex p-3">
                    <div class="col-md-6 mb-3 pe-2">
                      <div class="mb-3 selectTipo">
                        <select class="form-select" name="tipoDoc" id="input-tipo-doc" required>
                          <option selected disabled>Tipo de documento...</option>
                          <option value="1">DNI</option>
                          <option value="2">Pasaporte</option>
                          <option value="3">Cédula de identidad</option>
                          <option value="4">Otro</option>
                        </select>
                        <div class="invalid-feedback" id="invalid-tipoDoc"></div>
                      </div>

                      <div id="addDoc" class="mb-3">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhotoDoc[]" id="addNewPhotoDoc" onchange="preVisualDoc(event)" multiple />
                        <div class="custom-file-upload mb-2">
                          <h2 id="addPhotoDoc">Documento➕</h2>
                        </div>
                        <select name="photosIdDoc[]" id="photosIdDoc" multiple hidden></select>
                        <div id="photosDoc"></div>
                        <div class="invalid-feedback" id="invalid-photosDoc"></div>
                      </div>
                    </div>

                    <div class="col-md-6 mb-3 ps-2">
                      <div class="mb-3 selectTipo">
                        <select class="form-select" name="tipoBol" id="input-tipo-bol" required>
                          <option selected disabled>Tipo de boleta...</option>
                          <option value="1">Factura de Servicios</option>
                          <option value="2">Boleta de impuestos</option>
                          <option value="3">Resumen de tarjeta de crédito o cuenta bancaria</option>
                          <option value="4">Contrato de alquiler</option>
                          <option value="5">Otro</option>
                        </select>
                        <div class="invalid-feedback" id="invalid-tipoBol"></div>
                      </div>

                      <div id="addBol" class="mb-3">
                        <input type="file" accept="image/png, image/jpeg, image/jpg" name="addNewPhotoBol[]" id="addNewPhotoBol" onchange="preVisualBol(event)" multiple />
                        <div class="custom-file-upload mb-2">
                          <h2 id="addPhotoBol">Boleta➕</h2>
                        </div>
                        <select name="photosIdBol[]" id="photosIdBol" multiple hidden></select>
                        <div id="photosBol"></div>
                        <div class="invalid-feedback" id="invalid-photosBol"></div>
                      </div>
                    </div>
                  </div>

                </div>
                <input type="hidden" name="verificacionEnviada">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-morado" data-bs-dismiss="modal">Cerrar</button>
              <input type="submit" id="btn-enviar" form="formVerificar" class="btn btn-amarillo"></input>
            </div>
          </div>
        </div>

      </div>

    <?php
    }
    ?>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/components/nuevaPublicacion.php') ?>

    <!-- Imprime todas las publicaciones activas en la base de datos -->
    <?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/components/publicaciones.php");
    echo renderPublicaciones();
    ?>
  </div>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/Footer.php"); ?>
  <?php require_once($_SERVER["DOCUMENT_ROOT"] . "/components/JS.php"); ?>
  <?php
  if ($_SESSION["esVerificado"] == 0) echo '<script src="../js/verificarUsuario.js"></script>';
  ?>
  <script src="../js/postulacion.js"></script>
</body>

</html>