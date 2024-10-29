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
        .then(response => {
            // Imprimir la respuesta completa antes de convertirla a JSON
            return response.text(); // Cambia a text para ver el contenido
        })
        .then(text => {
            console.log(text); // Muestra la respuesta en la consola
            try {
                const data = JSON.parse(text); // Intenta parsear como JSON
                if (data.success) {
                    alert('Estado actualizado correctamente');
                    location.reload();
                } else {
                    console.error('Error:', data.error || data.message);
                    alert('Hubo un error al cambiar el estado: ' + (data.message || 'Sin detalles'));
                }
            } catch (error) {
                console.error('Error de análisis JSON:', error);
                alert('Respuesta del servidor no válida. Revise la consola para más detalles.');
            }
        })
        .catch(error => console.error('Error:', error));
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
        .then(response => {
            // Imprimir la respuesta completa antes de convertirla a JSON
            return response.text(); // Cambia a text para ver el contenido
        })
        .then(text => {
            console.log(text); // Muestra la respuesta en la consola
            try {
                const data = JSON.parse(text); // Intenta parsear como JSON
                if (data.success) {
                    alert('Estado actualizado correctamente');
                    location.reload();
                } else {
                    console.error('Error:', data.error || data.message);
                    alert('Hubo un error al cambiar el estado: ' + (data.message || 'Sin detalles'));
                }
            } catch (error) {
                console.error('Error de análisis JSON:', error);
                alert('Respuesta del servidor no válida. Revise la consola para más detalles.');
            }
        })
        .catch(error => console.error('Error:', error));
}