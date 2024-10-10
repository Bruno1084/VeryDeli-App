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
            <img class="img-fluid" src="../assets/Very.png" alt="Very Deli" title="Very Deli logo" width="235" height="235">
            <h2> Ingrese el codigo de verificacion para continuar </h2>
        </div>

        <div class="d-flex justify-content-center">
            <div class="form-rest my-4 col-8"></div>
        </div>

        <div class="container py-3">
            <form class="formulario-recuperacion" action="../utils/validarToken.php" method="post">
                <div class="row justify-content-center">
                    <div class="form-group col-md-6 mb-3">
                        <label for="codigo">Codigo de Verificacion</label>
                        <input type="number" min="100000" max="999999" class="form-control bg-input" id="codigo" name="codigo" required placeholder="Ej: 123456">
                    </div>
                </div>

                <div class="row justify-content-center my-3">
                    <div class="col-8 col-md-5 text-center">
                        <button type="submit" class="btn btn-morado btn-block">verificar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    var intentos=0;
    const correo=JSON.parse(<?php echo json_encode($_SESSION["email"]) ?>);
    
    window.onload(console.log(correo));
</script>
</html>