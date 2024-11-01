function validarVerificacion () {
  let esValido = true;
  
  return esValido
}

(() => {
  const forms = document.querySelectorAll('.form-verificar');
  forms.forEach(form => {
    form.addEventListener('submit', function (event) {  
      event.preventDefault();
      return validado=()=>new Promise((resolve)=>{
        if (validarVerificacion()){
          $('#modalVerificar').modal('hide');
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