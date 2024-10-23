function validarReporte(idPublicacion){
  let id = parseInt(idPublicacion);
  let isValid = true;

  const motivo = document.getElementById('input-motivo' + id);
  const motivoFeedback = document.getElementById('invalid-motivo' + id);

  if (motivo.value === "Seleccione un motivo..." || !motivo.value) {
    motivo.classList.add('is-invalid');
    motivoFeedback.textContent = 'Debe seleccionar un motivo para el reporte';
    isValid = false
  } else {
    motivo.classList.remove('is-invalid');
    motivo.classList.add('is-valid');
    motivoFeedback.textContent = '';
  }

  const mensaje = document.getElementById('reporte-mensaje' + id);
  const mensajeFeedback = document.getElementById('invalid-reporteMensaje' + id);

  if(mensaje.value.trim() != ''){
    if(mensaje.value.trim().length < 15){
      mensaje.classList.add('is-invalid');
      mensajeFeedback.textContent = 'El mensaje debe contener minimo 15 caracteres';
      isValid = false;
    } else {
      mensaje.classList.remove('is-invalid');
      mensaje.classList.add('is-valid');
      mensajeFeedback.textContent = '';
    }
  } else {
    mensaje.classList.remove('is-invalid')
    mensaje.classList.add('is-valid');
    mensajeFeedback.textContent = '';
  }
  return isValid;
}

(() => {
  const forms = document.querySelectorAll('.form-reportar');
  forms.forEach(form => {
    form.addEventListener('submit', async function (event) {  
      let idPublicacion = parseInt(form.getAttribute("id").replace('formReportar', ''));
      event.preventDefault();
      return validado=()=>new Promise((resolve)=>{
        if (validarReporte(idPublicacion)){
          resolve(true);
        }
        else{
          resolve(false);
        }
      });
    }, false);
  })
})
