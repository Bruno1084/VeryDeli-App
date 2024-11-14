<!DOCTYPE html>
<html lang="en">

<head>
    <?php require($_SERVER["DOCUMENT_ROOT"] . "/utils/functions/startSession.php"); ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
    <link rel="stylesheet" href="/css/miPerfil.css">
    <link rel="stylesheet" href="/css/publicacionAcotada.css">
    <title>Mi Perfil</title>
</head>

<body>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . '/database/conection.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getAllPostulacionFromUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/utils/get/getAVGCalificacionesFromUsuario.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/components/publicacionesUser.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/functions/funcionesCalificaciones.php");
    ?>
    <?php
    $info_usuario = getUsuario($_SESSION["id"]);
    $id = $_SESSION["id"];
    $info_postulaciones = getAllPostulacionFromUsuario($_SESSION["id"]);
    $promedio = getAVGCalificacionesFromUsuario($_SESSION["id"]);
    function esPost($info_postulaciones)
    {
        if (empty($info_postulaciones)) {
            return "1";
        } else {
            return "0";
        }
    }
    function estadoPost($estado)
    {
        if ($estado == 0) {
            return "Pendiente";
        } else if ($estado == 1) {
            return "Aceptada";
        } else if ($estado == 2) {
            return "Rechazada";
        }
    }
    function esRes($esResponsable)
    {
        if ($esResponsable == 0) {
            return "<p>No Responsable</p>";
        } else {
            return "<p>Responsable</p>";
        }
    };

    
    ?>
    <section class="col-12 cuerpo">
        <aside class="col-2 perfil shadow border border-dark-subtle rounded">
            <div class="perfil_user">
                <div class="col-12 user_photo">
                    <?php if ($_SESSION["marcoFoto"] == 0) { ?>
                        <div class="userFoto">
                            <img src="<?php echo tieneFoto() ?>" class="userFoto" alt="user">
                        </div>
                    <?php   } else {
                        echo '<div class="fondoFoto"></div><img src="' . $_SESSION["marcoFoto"] . '" class="decoFoto' . $_SESSION["marcoFoto"][(strlen($_SESSION["marcoFoto"]) - 5)] . '">';
                        echo '<div class="divFoto"><img src="' . tieneFoto() . '" alt="user"></div>';
                    } ?>
                </div>
                <div class="col-12 user_name">
                    <h4><?php echo $info_usuario['usuario_nombre']; ?></h4>
                    <h4><?php echo $info_usuario['usuario_apellido']; ?></h4>
                </div>
            </div>
            <div class="perfil_options">
                <a href="#">Modificar perfil</a>
                <?php if ($_SESSION["esAdmin"] == 1) { ?>
                    <a class="text-reset" href="/pages/verificaciones.php">Verificaciones</a>
                    <a class="text-reset" href='/pages/denuncias.php'>Denuncias</a>
                <?php }; ?>

            </div>
            <div class="perfil_info">
                <p>Localidad: <?php echo $info_usuario['usuario_localidad']; ?></p>
                <a href="mailTo:<?php echo $info_usuario['usuario_correo']; ?>"><?php echo $info_usuario['usuario_correo']; ?></a>
                <?php echo esRes($_SESSION["esResponsable"]) ?>
            </div>
            <div class="perfil_calificacion">
                <div class="calificacion_titulo">
                    <h3>Calificacion</h3>
                </div>
                <div class="calificacion_puntaje">
                    <?php echo estadoCalif($promedio) ?>
                </div>
            </div>
        </aside>
        <div class="col-7 contenedor">

            <?php echo renderPubsAndComsUser() ?>

        </div>
        <aside class="col-2">
            <div class="col-12 postulaciones  shadow border border-dark-subtle rounded">
                <div class="col-12 postulacion_titulo">
                    <?php
                    if (esPost($info_postulaciones) == 1) {
                        echo "<h6>Sin Postulaciones</h6>";
                    } else {
                        echo "<h6>Postulaciones</h6>";
                    }
                    ?>
                </div>
                <div>
                    <?php
                    if (esPost($info_postulaciones) == 1) {
                        echo "<div class='col-12 postulacion' name='postulacion'><p class='text-center'>sin informacion</p></div>";
                    } else {
                        foreach ($info_postulaciones as $postulacion):
                    ?>
                            <div class="col-12" name="postulacion">
                                <a class="text-reset text-decoration-none d-flex postulacion" href="<?php echo '../pages/publicacion.php?id=' . $postulacion["publicacion_id"] ?>">
                                    <p><?php echo estadoPost($postulacion["postulacion_estado"]) ?></p>
                                    <p><?php echo date('H:i d/m/Y', strtotime($postulacion["postulacion_fecha"])) ?></p>
                                </a>
                            </div>
                    <?php
                        endforeach;
                    }
                    ?>
                </div>
            </div>
        </aside>
    </section>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
</body>

</html>