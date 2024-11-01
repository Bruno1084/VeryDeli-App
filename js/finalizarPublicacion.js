function finalizarPublicacion(publicacion) {
        let contenedor = document.querySelector('.form-rest');  
        fetch('/utils/finalizarPublicacion.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({
              id: parseInt(publicacion),
          })
      })
      .then(respuesta => {
          if (!respuesta.ok) { 
              throw new Error('Error en la solicitud: ' + respuesta.status);
          }
          return respuesta.text(); 
      })
      .then(text => {
          if (text) { 
              const data = JSON.parse(text);
              contenedor.innerHTML = data.message;
              if (data.redirect) {
                  setTimeout(() => {
                      window.location.href = data.redirect;
                  }, 2000); 
              }
          } else {
              throw new Error("Respuesta vacía del servidor");
          }
      })
      .catch(error => {
          contenedor.innerHTML = '<div class="text-bg-danger p-3">Error: ' + error.message + '</div>';
      });
}
