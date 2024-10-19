function validarPostulacion(idPublicacion){
  let isValid = true;
  let id = parseInt(idPublicacion);
  //Validar monto
  const monto = document.getElementById('postulacion-monto' + id);
  const montoFeedBack = document.getElementById('invalid-monto' + id);
  if(monto.value <= 0) {
    monto.classList.add('is-invalid');
    montoFeedBack.textContent = 'Ingrese un valor mayor a 0';
    isValid  = false;
  } else {
    monto.classList.remove('is-invalid');
    monto.classList.add('is-valid');
    montoFeedBack.textContent = '';
  }
  //Validar descripcion
  const descripcion = document.getElementById('postulacion-descripcion' + id);
  const descripcionFeedBack = document.getElementById('invalid-pDescripcion' + id);
  if(descripcion.value.trim() !== '') {
    if(descripcion.value.length < 15) {
      descripcion.classList.add('is-invalid');
      descripcionFeedBack.textContent = 'La descripcion debe contener minimo 15 caracteres';
      isValid = false;
    } else {
      descripcion.classList.remove('is-invalid');
      descripcion.classList.add('is-valid');
      descripcionFeedBack.textContent = '';
    }
  } else{
    descripcion.classList.remove('is-invalid');
    descripcion.classList.add('is-valid');
    descripcionFeedBack.textContent = '';
  }
  return isValid;
}

(() => {
  const forms = document.querySelectorAll('.form-postularse');
  forms.forEach(form => {
    form.addEventListener('submit', function (event) {  
      let idPublicacion = parseInt(form.getAttribute("id").replace('formPostularse', ''));
      event.preventDefault();
      if (!validarPostulacion(idPublicacion)) {
        event.stopPropagation();
      } 
    }, false);
  })
})