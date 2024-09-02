
const formularios_ajax = document.querySelectorAll(".FormularioAjax");


function enviarFormularioAjax(e){
  e.preventDefault();
  let data = new FormData(this); // Almacena los datos del formulario
  let method = this.getAttribute("method"); // Almacena el metodo de envio
  let action = this.getAttribute("action");   // Almacena la url donde se enviara el formulario
  let config = {  // Almacena las configuracion a utilizar en el envio por fetch
    method : method,
    mode : "cors",
    cache : "no-cache",
    body : data
    };
  fetch(action, config)
  .then(respuesta => respuesta.text()) // Almacenamos la respuesta del receptor
  .then(respuesta =>{ //instrucciones para mostrar la respuesta
    let contenedor = document.querySelector(".form-rest");
    contenedor.innerHTML = respuesta;
    this.reset();
  });
}

formularios_ajax.forEach(formulario =>{
    formulario.addEventListener("submit", enviarFormularioAjax);
});

