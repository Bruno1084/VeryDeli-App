 // Validación para el formulario
function validarPublicacion() {
  let isValid = true; 
  const titulo = document.getElementById('publicacion-titulo');
  const tituloFeedback = document.getElementById('invalid-titulo');

  if (titulo.value.trim() == '') {
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
  if (descripcion.value.trim() == '') {
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
  const volumenValor = parseFloat(volumen.value.trim());
  if (volumenValor == '') {
    volumenFeedback.textContent = 'El volumen es obligatorio.';
    volumen.classList.add('is-invalid');
    isValid = false;
  } else if (isNaN(volumenValor)) {
    volumenFeedback.textContent = 'El volumen debe ser un número.';
    volumen.classList.add('is-invalid');
    isValid = false;
  } else if(volumenValor <= 0){
    volumenFeedback.textContent = 'El volumen debe ser mayor a 0';
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
  const pesoValor = parseFloat(peso.value.trim());
  if (pesoValor == '') {
    pesoFeedback.textContent = 'El peso es obligatorio.';
    peso.classList.add('is-invalid');
    isValid = false;
  } else if (isNaN(pesoValor)) {
    pesoFeedback.textContent = 'El peso debe ser un número.';
    peso.classList.add('is-invalid');
    isValid = false;
  } else if(pesoValor <= 0){
    pesoFeedback.textContent = 'El peso debe ser mayor a 0';
    peso.classList.add('is-invalid');
    isValid = false;
  } else {
    peso.classList.remove('is-invalid');
    peso.classList.add('is-valid');
    pesoFeedback.textContent = '';
  }
// Validar Origen y Destino
  const origen_barrio = document.querySelector('#publicacion-origen-barrio');
  const origen_barrio_Feedback = document.querySelector('#invalid-origen-barrio');
  if (origen_barrio.value.trim() == '') {
    origen_barrio_Feedback.textContent = 'El barrio de origen es obligatorio.';
    origen_barrio.classList.add('is-invalid');
    isValid = false;
  } else {
    origen_barrio.classList.remove('is-invalid');
    origen_barrio.classList.add('is-valid');
    origen_barrio_Feedback.textContent = '';
  }
  const origen_manzana = document.querySelector('#publicacion-origen-manzana');
  const origen_manzana_Feedback = document.querySelector('#invalid-origen-manzana');
  if (origen_manzana.value.trim() == '') {
    origen_manzana_Feedback.textContent = 'La manzana/piso de origen es obligatorio.';
    origen_manzana.classList.add('is-invalid');
    isValid = false;
  } else {
    origen_manzana.classList.remove('is-invalid');
    origen_manzana.classList.add('is-valid');
    origen_manzana_Feedback.textContent = '';
  }
  const origen_casa = document.querySelector('#publicacion-origen-casa');
  const origen_casa_Feedback = document.querySelector('#invalid-origen-casa');
  if (origen_casa.value.trim() == '') {
    origen_casa_Feedback.textContent = 'La casa/depto de origen es obligatorio.';
    origen_casa.classList.add('is-invalid');
    isValid = false;
  } else {
    origen_casa.classList.remove('is-invalid');
    origen_casa.classList.add('is-valid');
    origen_casa_Feedback.textContent = '';
  }
  
  const destino_barrio = document.querySelector('#publicacion-destino-barrio');
  const destino_barrio_Feedback = document.querySelector('#invalid-destino-barrio');
  if (destino_barrio.value.trim() == '') {
    destino_barrio_Feedback.textContent = 'El barrio de destino es obligatorio.';
    destino_barrio.classList.add('is-invalid');
    isValid = false;
  } else {
    destino_barrio.classList.remove('is-invalid');
    destino_barrio.classList.add('is-valid');
    destino_barrio_Feedback.textContent = '';
  }
  const destino_manzana = document.querySelector('#publicacion-destino-manzana');
  const destino_manzana_Feedback = document.querySelector('#invalid-destino-manzana');
  if (destino_manzana.value.trim() == '') {
    destino_manzana_Feedback.textContent = 'La manzana/piso de destino es obligatorio.';
    destino_manzana.classList.add('is-invalid');
    isValid = false;
  } else {
    destino_manzana.classList.remove('is-invalid');
    destino_manzana.classList.add('is-valid');
    destino_manzana_Feedback.textContent = '';
  }
  const destino_casa = document.querySelector('#publicacion-destino-casa');
  const destino_casa_Feedback = document.querySelector('#invalid-destino-casa');
  if (destino_casa.value.trim() == '') {
    destino_casa_Feedback.textContent = 'La casa/depto de destino es obligatorio.';
    destino_casa.classList.add('is-invalid');
    isValid = false;
  } else {
    destino_casa.classList.remove('is-invalid');
    destino_casa.classList.add('is-valid');
    destino_casa_Feedback.textContent = '';
  }
  const mapaFeedback = document.querySelector('#invalid-map');
  const origen = document.querySelector('#coordsOrigen');
  const destino = document.querySelector('#coordsDestino');
  if (origen.value.trim() == '' && destino.value.trim() == '') {
    mapaFeedback.textContent = 'Seleccione el origen y el destino en el mapa.';
    mapaFeedback.setAttribute("style","display:flex;flex-direction:column;align-items:center");
    origen.classList.add('is-invalid');
    destino.classList.add('is-invalid');
    isValid = false;
  } else if (origen.value.trim() == '') {
    mapaFeedback.textContent = 'Seleccione el origen en el mapa.';
    mapaFeedback.setAttribute("style","display:flex;flex-direction:column;align-items:center");
    origen.classList.add('is-invalid');
    isValid = false;
  } else if (destino.value.trim() == '') {
    mapaFeedback.textContent = 'Seleccione el destino en el mapa.';
    mapaFeedback.setAttribute("style","display:flex;flex-direction:column;align-items:center");
    destino.classList.add('is-invalid');
    isValid = false;
  } else {
    origen.classList.remove('is-invalid');
    origen.classList.add('is-valid');
    destino.classList.remove('is-invalid');
    destino.classList.add('is-valid');
    mapaFeedback.textContent = '';
  }
  
// Validar persona recibe
  const regexAlfa = /^[a-zA-Z\s]+$/;
  const recibe = document.getElementById('publicacion-recibe');
  const recibeFeedback = document.getElementById('invalid-recibe');
  if(recibe.value.trim() == ""){
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
  if (contacto.value.trim() == '') {
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

// Validar Fotos
  const imagenes = document.querySelector('#photos');
  const cantImagenes = document.querySelector('#photos').childElementCount;
  const imagenFeedBack = document.getElementById('invalid-photos');
  if (cantImagenes < 1) {
    imagenFeedBack.textContent = 'Ingrese al menos una foto';
    imagenes.classList.add('is-invalid');
    imagenFeedBack.setAttribute("style","display:block");
    isValid = false;
  } else{
    imagenes.classList.remove('is-invalid');
    imagenes.classList.add('is-valid');
    imagenFeedBack.textContent = "";
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
    respuesta => console.log(respuesta.json())
  )
  .then(
      response=>console.log(response))
}