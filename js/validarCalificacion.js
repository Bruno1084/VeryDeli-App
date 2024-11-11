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

    return isValid;
  }
  
  (() => {
    const forms = document.querySelectorAll('.form-calificar');
    forms.forEach(form => {
      form.addEventListener('submit', function (event) {  
        event.preventDefault();
        return validado=()=>new Promise((resolve)=>{
          if (validarCalificacion()){
            $('#modalCalificar').modal('hide');
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