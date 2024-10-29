<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../js/ajax.js"></script>
</head>

<body class="container d-flex justify-content-center">
    <div class="border col-8 my-4 rounded shadow">
        <div class="text-center">
            <img class="img-fluid" src="../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
            <h2> Iniciar Sesión</h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="form-rest my-4 col-8"></div>
        </div>

        <div class="container py-3">
            <form class="formulario-registro FormularioAjax" action="/utils/iniciarSesion.php" method="post">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control bg-input" id="usuario" name="usuario" required placeholder="Ingrese su usuario">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" class="form-control bg-input" id="contraseña" name="contraseña" required placeholder="Ingrese su contraseña">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3 text-end">
                        <a href="./resetPass/emailRecuperacion.php" class="rst-pass">¿Olvidó su contraseña?</a>
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-8 col-md-5 text-center">
                        <button type="submit" class="btn btn-morado btn-block">Acceder</button>
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-8 col-md-5 text-center">
                        <a href="../components/registarse.php" class="btn btn-amarillo btn-block">Registrarse</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
<script>
    (() => {
    const form = document.querySelector('.formulario-registro');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        return validado=()=>new Promise((resolve)=>{
        if (1==1){
            resolve(true);
        }
        else{
            resolve(false);
        }
        });
    }, false);
    })();
</script>

</html>