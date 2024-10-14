function validarPostulacion(){
  let isValid = true;
  //Validar monto
  const monto = document.getElementById('postulacion-monto');
  const montoFeedBack = document.getElementById('invalid-monto');
  if(monto.value <= 0) {
    monto.classList.add('is-invalid');
    montoFeedBack.textContent = 'Ingrese un valor mayor a 0';
    isValid  = false;
  } else {
    monto.classList.remove('is-invalid');
    monto.classList.add('is-valid');
    montoFeedBack.textContent = '';
    isValid = true;
  }
  //Validar descripcion
  const descripcion = document.getElementById('postulacion-descripcion');
  const descripcionFeedBack = document.getElementById('invalid-pDescripcion');
  if(descripcion.value.trim !== '') {
    if(descripcion.value.length < 15) {
      descripcion.classList.add('is-invalid');
      descripcionFeedBack.textContent = 'La descripcion debe contener minimo 15 caracteres';
      isValid = false;
    } else {
      descripcion.classList.remove('is-invalid');
      descripcion.classList.add('is-valid');
      descripcionFeedBack.textContent = '';
      isValid = true;
    }
  }
  return isValid;
}

(() => {
  const forms = document.querySelectorAll('.form-postularse');
  forms.forEach(form => {
    form.addEventListener('submit', function (event) {  
      event.preventDefault();
      if (!validarPostulacion()) {
        event.stopPropagation();
      } 
    }, false);
  })
})