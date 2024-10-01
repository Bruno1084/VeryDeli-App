<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    require_once("../components/head.php");
    require_once("../components/JS.php");
    ?>
</head>

<body>
    
    <div class="mt-5 text-center">
        <h2 class="fw-bold">Very Deli</h2>
        <img class="img-fluid" src="../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
        <h2> Iniciar Sesión</h2>
    </div>

    <div class="d-flex justify-content-center">
        <div class="form-rest my-5 col-8"></div>
    </div>

    <div class="container py-4">
        <form class="formulario-registro FormularioAjax" action="../utils/iniciarSesion.php" method="post">
            <div class="row justify-content-center">
                <div class="form-group col-8 col-md-5 mb-3">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control bg-input" id="usuario" name="usuario" required placeholder="Ingrese su usuario">
                </div>
            </div>
            
            <div class="row justify-content-center">
                <div class="form-group col-8 col-md-5 mb-3">
                    <label for="contraseña">Contraseña</label>
                    <input type="password" class="form-control bg-input" id="contraseña" name="contraseña" required placeholder="Ingrese su contraseña">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-8 col-md-5 mb-3 text-end">
                    <a href="#" class="fw-bold rst-pass">¿Olvidó su contraseña?</a>
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
</body>
</html>