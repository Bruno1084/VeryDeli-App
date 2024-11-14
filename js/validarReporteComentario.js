function validarReporteComentario(){
    let isValid = true;
  
    const motivo = document.querySelector('#input-motivo');
    const motivoFeedback = document.querySelector('#invalid-motivo');
  
    if (motivo.value === "Seleccione un motivo..." || !motivo.value) {
      motivo.classList.add('is-invalid');
      motivoFeedback.textContent = 'Debe seleccionar un motivo para el reporte';
      isValid = false
    } else {
      motivo.classList.remove('is-invalid');
      motivo.classList.add('is-valid');
      motivoFeedback.textContent = '';
    }
  
    const mensaje = document.querySelector('#reporte-mensaje');
    const mensajeFeedback = document.querySelector('#invalid-reporteMensaje');
  
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
    const form = document.querySelector('.form-reportarComentario');
    form.addEventListener('submit', function (event) {  
        event.preventDefault();
        return validado=()=>new Promise((resolve)=>{
          if (validarReporteComentario()){
            document.querySelector('#cerrarModalReportarComentario').click();
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
  })()