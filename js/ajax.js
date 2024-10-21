

const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviarFormularioAjax(e){
  e.preventDefault();
  let contenedor = document.querySelector('.form-rest');
  let data = new FormData(this); // Almacena los datos del formulario
  let method = this.getAttribute("method"); // Almacena el metodo de envio
  let action = this.getAttribute("action"); // Almacena la url donde se enviara el formulario
  let config = {  // Almacena las configuraciones a utilizar en el envio por fetch
    method: method,
    mode: "cors",
    cache: "no-cache",
    body: data
  };

  // Realiza una solicitud HTTP
  fetch(action, config)
    
    .then(respuesta => {
      if (!respuesta.ok) { // Verifica si la respuesta es un error
        throw new Error('Error en la solicitud: ' + respuesta.status);
      }
      return respuesta.json();
    })
    .then(data => {
      // Muestra la respuesta en el contenedor
      contenedor.innerHTML = data.message
      if (data.redirect) {
        setTimeout(() => {
          window.location.href = data.redirect;
        }, 2000); 
      }
    })
    .catch(error => {
      contenedor.innerHTML = '<div class="text-bg-danger p-3">Error: ' + error.message + '</div>'; // Muestra el error
    });
}

// Asigna el evento "submit" a los formularios al cargar la página
document.addEventListener("DOMContentLoaded", () => {
  const formularios_ajax = document.querySelectorAll(".FormularioAjax"); 
  formularios_ajax.forEach(formulario => {
    formulario.addEventListener("submit", enviarFormularioAjax); 
  });
});