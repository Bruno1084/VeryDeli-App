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
          width: 100px;
          height: 100px;
          object-fit: cover;
          margin-right: 5px;
          margin-bottom: 5px;
          transition: width 50ms, height 50ms;
        }

        #photos img:hover{
          width: 200px;
          height: 200px;
          filter:brightness(50%)
        }

        #addPhoto{
          display: inline-block;
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
          <form action="#" class="form-publicacion needs-validation" novalidate method="post" enctype="multipart/form-data" id="formPublicacion" autocomplete="off" onsubmit="return validarPublicacion()">
            <div class="row">
              <div class="col-3 mb-3">
                <input type="text" class="form-control " id="publicacion-titulo" name="titulo" placeholder="Titulo">
                <div class="invalid-feedback" id="invalid-titulo">
                
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <textarea style="height: 120px; max-height:120px" class="form-control" id="publicacion-descripcion" name="descripcion" placeholder="Descripcion"></textarea>
                <div class="invalid-feedback" id="invalid-descripcion"></div>
              </div>
            </div>

            
            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control mb-3" id="publicacion-volumen" name="volumen"  placeholder="Volumen">
                <div class="invalid-feedback" id="invalid-volumen"></div>
              </div>
              <div class="col-3">
                <input type="text" class="form-control" id="publicacion-peso" name="peso"  placeholder="Peso">
                <div class="invalid-feedback" id="invalid-peso"></div>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-3">
                <input type="text" class="form-control mb-3" id="publicacion-origen" name="origen"  placeholder="Origen">
                <div class="invalid-feedback" id="invalid-origen"></div>
                <input type="text" class="form-control" id="publicacion-destino" name="destino"  placeholder="Destino">
                <div class="invalid-feedback" id="invalid-destino"></div>
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-3 mb-3">
                <input type="text" class="form-control" id="publicacion-recibe" name="recibe"  placeholder="Encargado de Recibir">
                <div class="invalid-feedback" id="invalid-recibe"> </div>
              </div>

              <div class="col-3">
                <input type="tel" class="form-control" id="publicacion-contacto" name="contacto"  placeholder="Telefono de Contacto">
                <div class="invalid-feedback" id="invalid-contacto"> </div>
              </div>
            </div>

            <div class="row">
              <div id="add" class="col-12 mb-3">
                <input type="text" name="photosId" id="photosId" value="" hidden>
                <h2 id="addPhoto">Fotos ➕</h2>
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
  // Validación personalizada
  function validarPublicacion() {
  let isValid = true; 
  const titulo = document.getElementById('publicacion-titulo');
  const tituloFeedback = document.getElementById('invalid-titulo');

  if (titulo.value.trim() === '') {
    tituloFeedback.textContent = 'El título no puede estar vacío.';
    titulo.classList.add('is-invalid');
    isValid = false;
  } else if (titulo.value.length < 5) {
    tituloFeedback.textContent = 'El título debe tener al menos 5 caracteres.';
    titulo.classList.add('is-invalid');
    isValid = false;
  } else {
    titulo.classList.remove('is-invalid');
    titulo.classList.add('is-valid');
  }
  // Validar Descripción
  const descripcion = document.getElementById('publicacion-descripcion');
  const descripcionFeedback =document.getElementById('invalid-descripcion')
  if (descripcion.value.trim() === '') {
    descripcionFeedback.textContent = 'La descripción no puede estar vacía.';
    descripcion.classList.add('is-invalid');
    isValid = false;
  } else if (descripcion.value.length < 20) {
    descripcionFeedback.textContent = 'La descripción debe tener al menos 20 caracteres.';
    descripcion.classList.add('is-invalid');
    isValid = false;
  } else {
    descripcion.classList.remove('is-invalid');
    descripcion.classList.add('is-valid');
  }
  // Validar Volumen
  const volumen = document.getElementById('publicacion-volumen');
  const volumenFeedback =document.getElementById('invalid-volumen');
  if (volumen.value.trim() === '') {
    volumenFeedback.textContent = 'El volumen es obligatorio.';
    volumen.classList.add('is-invalid');
    isValid = false;
  } else if (isNaN(volumen.value)) {
    volumenFeedback.textContent = 'El volumen debe ser un número.';
    volumen.classList.add('is-invalid');
    isValid = false;
  } else {
    volumen.classList.remove('is-invalid');
    volumen.classList.add('is-valid');
  }

  // Validar Peso
  const peso = document.getElementById('publicacion-peso');
  const pesoFeedback = document.getElementById('invalid-peso');
  if (peso.value.trim() === '') {
    pesoFeedback.textContent = 'El peso es obligatorio.';
    peso.classList.add('is-invalid');
    isValid = false;
  } else if (isNaN(peso.value)) {
    pesoFeedback.textContent = 'El peso debe ser un número.';
    peso.classList.add('is-invalid');
    isValid = false;
  } else {
    peso.classList.remove('is-invalid');
    peso.classList.add('is-valid');
  }

  // Validar Origen y Destino
  const origen = document.getElementById('publicacion-origen');
  const destino = document.getElementById('publicacion-destino');
  const origenFeedback = document.getElementById('invalid-origen')
  const destinoFeedback =document.getElementById('invalid-destino');
  if (origen.value.trim() === '') {
    origenFeedback.textContent = 'El lugar de origen es obligatorio.';
    origen.classList.add('is-invalid');
    isValid = false;
  } else {
    origen.classList.remove('is-invalid');
    origen.classList.add('is-valid');
  }
  if (destino.value.trim() === '') {
    destinoFeedback.textContent = 'El lugar de destino es obligatorio.';
    destino.classList.add('is-invalid');
    isValid = false;
  } else {
    destino.classList.remove('is-invalid');
    destino.classList.add('is-valid');
  }

  // Validar persona recibe
  const regexAlfa = /^[a-zA-Z\s]+$/;
  const recibe = document.getElementById('publicacion-recibe');
  const recibeFeedback = document.getElementById('invalid-recibe');
  if(recibe.value.trim() === ""){
    recibeFeedback.textContent = 'Los datos del encargado de recibir la entrega son obligatorios!';
    recibe.classList.add('is-invalid');
    isValid = false;
  } else if (!regexAlfa.test(recibe.value)) {
    recibeFeedback.textContent = 'Ingrese un nombre valido (sin numeros ni caracteres especiales)';
    recibe.classList.add('is-invalid');
    isValid = false;
  } else if (recibe.value.trim().length < 5){
    recibeFeedback.textContent = 'El nombre debe tener al menos 5 caracteres';
    recibe.classList.add('is-invalid');
  } else {
    recibe.classList.remove('is-invalid');
    recibe.classList.add('is-valid');
  }
  // Validar Teléfono de contacto
  const contacto = document.getElementById('publicacion-contacto');
  const contactoFeedback =document.getElementById('invalid-contacto');
  const regexTelefono = /^[0-9]{10,13}$/;
  if (contacto.value.trim() === '') {
    contactoFeedback.textContent = 'El teléfono de contacto es obligatorio.';
    contacto.classList.add('is-invalid');
    isValid = false;
  } else if(!regexTelefono.test(contacto.value)){
    contactoFeedback.textContent = 'Ingrese un número de teléfono valido!';
    contacto.classList.add('is-invalid');
    isValid = false;
  } else {
    contacto.classList.remove('is-invalid');
    contacto.classList.add('is-valid');
  }

  return isValid; 
}

(() => {
  'use strict';

  const form = document.getElementById('formPublicacion');

  form.addEventListener('submit', function (event) {
    if (!validarPublicacion()) {
    event.preventDefault();
    event.stopPropagation();
  } else {
    // Enviar formulario si es válido
    this.submit();
  }
  }, false);
})();

  </script>
  <?php require_once("../components/JS.php"); ?>
</body>
</html>
