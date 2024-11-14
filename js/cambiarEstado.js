function cambiarEstado(button, nuevoEstado, publicacion) {
    const postulacionId = button.getAttribute('data-id');
    fetch('/utils/administrarPostulacion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: parseInt(postulacionId),
                estado: nuevoEstado,
                publicacionId: parseInt(publicacion)
            })
        })
        .then(response => response.json()) 
        .then(data => {
            let contenedor = document.querySelector('.form-rest');
            let mensaje;
            if(nuevoEstado == "2"){
                mensaje = '<div class="text-bg-success p-3"><strong>¡Postulacion rechazada!</strong><br> La postulacion ha sido rechazada con exito </div>'
            } else{
                mensaje = '<div class="text-bg-success p-3"><strong>¡Postulacion aceptada!</strong><br> La postulacion ha sido aceptada con exito </div>'
            }
            if (data.success) {
                contenedor.innerHTML = mensaje;
            } else {
                    contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br> Intente de nuevo mas tarde</div>'
                }
            }).catch(error => {
                let contenedor = document.querySelector('.form-rest');
                contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br> Intente de nuevo más tarde</div>';
            })
            .finally(() => location.reload());  
}

function cancelarTransportista(button, nuevoEstado, publicacion) {
    const postulacionId = button.getAttribute('data-id');
    fetch('/utils/cancelarTransportista.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: parseInt(postulacionId),
                estado: nuevoEstado,
                publicacionId: parseInt(publicacion)
            })
        })
        .then(response => response.json()) 
        .then(data => {
            let contenedor = document.querySelector('.form-rest');
            if (data.success) {
                contenedor.innerHTML = '<div class="text-bg-success p-3"><strong>!Transportista cancelado!</strong><br>El transportista previamente seleccionado ya no esta a cargo de tu envio </div>'
            } else {
                contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br> Intente de nuevo mas tarde</div>'
            }
        }) .catch(error => {
            let contenedor = document.querySelector('.form-rest');
            contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br> Intente de nuevo más tarde</div>';
        })
        .finally(() => location.reload());
}

function eliminarPostulacion(button) {
    const postulacionId = button.getAttribute('data-id');
    const estadoPostulacion = button.getAttribute('data-estado');
    fetch('/utils/eliminarPostulacion.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: parseInt(postulacionId),
                estado: estadoPostulacion
            })
        })
        .then(response => response.json()) 
        .then(data => {
            let contenedor = document.querySelector('.form-rest');
            if (data.success) {
                contenedor.innerHTML = '<div class="text-bg-success p-3"><strong>!Postulacion eliminada!</strong><br>La postulacion se elimino con exito</div>'
            } else {
                contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Ocurrio un error!</strong><br>'+data.message+'</div>'
            }
        }) .catch(error => {
            let contenedor = document.querySelector('.form-rest');
            contenedor.innerHTML = '<div class="text-bg-danger p-3"><strong>¡Error inesperado!</strong><br> Intente de nuevo más tarde</div>';
        })
        .finally(() => location.reload());
}