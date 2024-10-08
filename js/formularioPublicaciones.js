 // Validación para el formulario
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
    tituloFeedback.textContent = '';
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
    descripcionFeedback.textContent = '';
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
    volumenFeedback.textContent = '';
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
    pesoFeedback.textContent = '';
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
    origenFeedback.textContent = '';
  }
  if (destino.value.trim() === '') {
    destinoFeedback.textContent = 'El lugar de destino es obligatorio.';
    destino.classList.add('is-invalid');
    isValid = false;
  } else {
    destino.classList.remove('is-invalid');
    destino.classList.add('is-valid');
    destinoFeedback.textContent = '';
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
    isValid = false;
  } else {
    recibe.classList.remove('is-invalid');
    recibe.classList.add('is-valid');
    recibeFeedback.textContent = '';
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
    contactoFeedback.textContent = '';
  }
  return isValid; 
}

(() => {
  const form = document.getElementById('formPublicacion');
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    if (!validarPublicacion()) {
      event.stopPropagation();
    } 
  }, false);
})();
const sendForm = async(action,config)=>{
  return await fetch(action,config)
  .then(
      respuesta => respuesta.text()
  )
  .then(
      response=>console.log(response))
}