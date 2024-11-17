function cambiarEstadoVerificacion(button, nuevoEstado) {
    const verificacionId = button.getAttribute('data-id');
    fetch('/utils/EstadoVerificacioon.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: parseInt(verificacionId),
                estado: nuevoEstado,
            })
        })
        .then(response => response.json()) 
        .then(data => {
            let contenedor = document.querySelector('.form-rest');
            let mensaje;
            if(nuevoEstado == "2"){
                mensaje = '<div class="text-bg-success p-3"><strong>¡Verificacion rechazada!</strong><br> La verificacion ha sido rechazada con exito </div>'
            } else{
                mensaje = '<div class="text-bg-success p-3"><strong>¡Verificacion aceptada!</strong><br> La verificacion ha sido aceptada con exito </div>'
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



