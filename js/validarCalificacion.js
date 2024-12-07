function validarCalificacion(){
    let isValid = true;
  
    const motivo = document.getElementById('inputPuntaje');
    const motivoFeedback = document.getElementById('invalid-puntaje');
  
    if (motivo.value === "Seleccione un puntaje" || !motivo.value) {
      motivo.classList.add('is-invalid');
      motivoFeedback.textContent = 'Debe seleccionar un puntaje para calificar al usuario';
      isValid = false
    } else {
      motivo.classList.remove('is-invalid');
      motivo.classList.add('is-valid');
      motivoFeedback.textContent = '';
    }
    const mensaje = document.getElementById('inputMensaje');
    const mensajeFeedback = document.getElementById('invalid-mensaje');
  
    if (mensaje.value.trim() !== '' && mensaje.value.length < 15) {
      mensaje.classList.add('is-invalid');
      mensajeFeedback.textContent = 'Ingrese al menos 15 caracteres';
      isValid = false
    } else {
      mensaje.classList.remove('is-invalid');
      mensaje.classList.add('is-valid');
      mensajeFeedback.textContent = '';
    }

    return isValid;
  }
  
  (() => {
    const forms = document.querySelectorAll('.form-calificar');
    forms.forEach(form => {
      form.addEventListener('submit', function (event) {  
        event.preventDefault();
        return validado=()=>new Promise((resolve)=>{
          if (validarCalificacion()){
            document.querySelector('#cerrarModalCalificar').click();
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });
            resolve(true);
          }
          else{
            resolve(false);
          }
        });
      }, false);
    })
  })()