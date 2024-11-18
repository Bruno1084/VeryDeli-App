<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once("../components/head.php");
    ?>
</head>

<body class="container d-flex justify-content-center">
<div class="border col-12 col-md-9 my-4 pb-4 rounded shadow">
        <div class="text-center">
            <img class="img-fluid" src="../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
            <h2>Registrarse</h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="form-rest my-4 p-3 col-12 col-md-8"></div>
        </div>

        <div class="container py-3">
            <form class="formulario-registro FormularioAjax" action="../utils/registerUser.php" method="post">
                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control bg-input" id="nombre" name="nombre" required placeholder="Ingrese su nombre">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control bg-input" id="apellido" name="apellido" required placeholder="Ingrese su apellido">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control bg-input" id="correo" name="correo" required placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control bg-input" id="localidad" name="localidad" required placeholder="Ingrese su localidad">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="usuario">Usuario</label>
                        <input type="text" class="form-control bg-input" id="usuario" name="usuario" required placeholder="Ingrese su nombre de usuario">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" class="form-control bg-input" id="contraseña" name="contraseña" required placeholder="Ingrese su contraseña">
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="form-group col-12 col-md-10 d-flex align-items-center mb-3">
                        <input type="checkbox" class="form-check-input bg-input" id="transportista" name="serTransportista">
                        <label class="form-check-label mx-2" for="transportista">Ser transportista</label>
                    </div>
                </div>

                <div class="additional-fields row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="tipoVehiculo">Tip. Vehículo</label>
                        <select class="form-control bg-input" id="tipoVehiculo" name="tipoVehiculo">
                            <option>Seleccionar...</option>
                            <option>Camión</option>
                            <option>Furgoneta</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="patente">Patente</label>
                        <input type="text" class="form-control bg-input" id="patente" name="patente" placeholder="Ingrese la patente del vehículo">
                    </div>
                </div>

                <div class="additional-fields row justify-content-center">
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="volumenSoportado">Volumen soportado</label>
                        <input type="number" step="0.001" class="form-control mb-3" id="volumenSoportado" name="volumenSoportado" placeholder="1200m³">
                    </div>
                    <div class="form-group col-12 col-md-5 mb-3">
                        <label for="pesoSoportado">Peso soportado</label>
                        <input type="number" step="0.001" class="form-control mb-3" id="pesoSoportado" name="pesoSoportado" placeholder="450kg">
                    </div>
                </div>

                <div class="text-center my-3">
                    <button type="submit" class="btn btn-amarillo">Crear</button>
                </div>
            </form>

            <div class="text-center">
                <a href="login.php" class="btn btn-morado">Iniciar Sesión</a>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="../js/ajax.js"></script>
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
    <script>
        // Si selecciona la opcion de ser transportista habilita los campos
        document.getElementById('transportista').addEventListener('change', function() {
            const additional_fields = document.getElementsByClassName('additional-fields');

            for (let i = 0; i < additional_fields.length; i++) {
                additional_fields[i].style.display = this.checked ? 'flex' : 'none';
            };
        });
    </script>
</body>

</html>