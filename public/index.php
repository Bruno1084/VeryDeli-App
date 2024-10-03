<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once("../components/head.php") ?>
  <title>Very Deli</title>
</head>
<body>
  <?php require_once("../components/Header.php");?>
  <?php
        $apiKey="b9a4cf5a03920383d33b750bae0914a0";
        $imgUpload="https://api.imgbb.com/1/upload";
    ?>
  <style>
        .addNewPhoto{
            display:none;
        }
        #photos {
          display: flex;
          flex-wrap: wrap;           
          max-width: 100%;
          gap: 5px; 
        }
        
        #photos img {
          width: 250px;
          height: 250px;
          object-fit: cover;
          margin-right: 5px;
          margin-bottom: 5px;
        }

    </style>

  <div class="modal fade" id="modalCrearPublicacion" aria-hidden="true" aria-labelledby="modalCrearPublicacionLabel" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content bg-modalPublicacion">
        <div class="modal-header" style="color:black; background-color:rgba(255, 255, 255, 80%)">
          <h1 class="modal-title fs-5" id="modalCrearPublicacionLabel">Nueva Publicación</h1>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form action="#" class="form-publicacion" method="post" enctype="multipart/form-data" id="formPublicacion" autocomplete="off" onsubmit="return validarPublicacion()">
            <div class="row">
              <div class="col-3 mb-3">
                <input type="text" class="form-control " id="publicacion-titulo" name="titulo" placeholder="Titulo" required>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="publicacion-descripcion" name="descripcion" placeholder="Descripcion" required></textarea>
              </div>
            </div>

            
            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control mb-3" id="publicacion-volumen" name="volumen" required placeholder="Volumen">
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="publicacion-peso" name="peso" required placeholder="Peso">
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-3">
                <input type="text" class="form-control mb-3" id="publicacion-origen" name="origen" required placeholder="Origen">
              
                <input type="text" class="form-control" id="publicacion-destino" name="destino" required placeholder="Destino">
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3 mb-3">
                <input type="text" class="form-control" id="publicacion-recibe" name="recibe" required placeholder="Encargado de Recibir">
              </div>

              <div class="col-3">
                <input type="tel" class="form-control" id="publicacion-contacto" name="contacto" required placeholder="Telefono de Contacto">
              </div>
            </div>

            <div class="row">
              <div id="add" class="col-12 mb-3">
                <input type="text" name="photosId" id="photosId" value="" hidden>
                <h2 id="addPhoto">Imagenes ➕</h2>
                <div id="photos"></div>
                <input type="file" class="addNewPhoto" accept="image/png, image/jpeg, image/jpg" name="addNewPhoto-0[]" id="addNewPhoto" multiple/>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-morado" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" form="formPublicacion" class="btn btn-amarillo">Crear Publicación</button>
        </div>
      </div>
    </div>
  </div>
  
  <button class="btn" id="btn-crearPublicacion" data-bs-target="#modalCrearPublicacion" data-bs-toggle="modal">Crear Publicación</button>
  <script src="../js/functions.js"></script>
  <script src="../js/inputFotos.js"></script>
  <script>
    function validarPublicacion(){
      return true;  // Permite el envío del formulario
    }

  </script>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
