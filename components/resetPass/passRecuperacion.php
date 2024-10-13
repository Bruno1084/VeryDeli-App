<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php");
    ?>
</head>

<body class="container d-flex justify-content-center">
    <div class="border col-8 my-4 rounded shadow">
        <div class="text-center">
            <img class="img-fluid" src="../../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
            <h2> Recuperar Contraseña </h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="form-rest my-4 col-8"></div>
        </div>

        <div class="container py-3">
            <form class="formulario-recuperacion" action="../../utils/resetPass/validarPassword.php" method="post">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <label for="pass">Nueva Contraseña</label>
                        <input type="password" class="form-control bg-input" id="pass" name="pass" required placeholder="Ingrese una nueva contraseña">
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-8 col-md-5 text-center">
                        <button type="submit" class="btn btn-morado btn-block">Crear</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script>
    var form=document.querySelector("form");
    form.addEventListener("submit",(e)=>{
        e.preventDefault();
        let contenedor = document.querySelector('.form-rest');
        let data = new FormData(form); // Almacena los datos del formulario
        let method = form.getAttribute("method"); // Almacena el metodo de envio
        let action = form.getAttribute("action"); // Almacena la url donde se enviara el formulario
        let config = {  // Almacena las configuraciones a utilizar en el envio por fetch
            method: method,
            mode: "cors",
            cache: "no-cache",
            body: data
        };
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
    })
</script>
</html>