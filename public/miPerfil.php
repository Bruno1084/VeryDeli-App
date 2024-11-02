<!DOCTYPE html>
<html lang="en">
<head>
    <?php require($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/components/head.php") ?>
    <link rel="stylesheet" href="/css/miPerfil.css">
    <title>Mi Perfil</title>
</head>
<body>
<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/components/Header.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');
    include_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getUsuario.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicacionesUser.php");
?>
<?php
    $info_usuario=getUsuario($_SESSION["id"]);
    function esRes($esResponsable){
        if($esResponsable==1){
            return "<p>Responsable</p>";
        }
        else{
            return "<p>No Responsable</p>";
        }
    }
    
            
?>
<section class="col-12 cuerpo">
    <aside class="col-2 perfil shadow border border-dark-subtle rounded">
        <div class="perfil_user">
            <div class="col-12 user_photo">
                <img class="img-fluid"src="/assets/Logo.png" alt="user">
            </div>
            <div class="col-12 user_name">
                <h4><?php echo $info_usuario['usuario_nombre']; ?></h4>
                <h4><?php echo $info_usuario['usuario_apellido']; ?></h4>
            </div>
        </div>
        <div class="perfil_links">
            <p>Localidad: <?php echo $info_usuario['usuario_localidad']; ?></p>
            <a href="mailTo:<?php echo $info_usuario['usuario_correo']; ?>"><?php echo $info_usuario['usuario_correo']; ?></a>
            <?php echo esRes($info_usuario["usuario_esResponsable"])?>
        </div>
        <div class="perfil_calificacion">
            <div class="calificacion_titulo">
                <h3>Calificacion</h3>
            </div>
            <div class="calificacion_puntaje">
                <img class="img-fluid" src="/assets/rating(0).svg" alt="rate">
                <p>0.0 de 0 calificaciones</p>
            </div>
        </div>
    </aside>
    <div class="col-7 contenedor">
        
        <?php echo renderPubsAndComsUser() ?>

    </div>
    <aside class="col-2">
        <div class="col-12 postulaciones  shadow border border-dark-subtle rounded">
            <div class="col-12 postulacion_titulo">
                <h3>Postulaciones</h3>
            </div>
            <div>
                <div class="col-12 postulacion" name="postulacionP" id="postulacionP-N">
                    <p>Pendiente</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionA" id="postulacionA-N">
                    <p>Aceptada</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionR" id="postulacionR-N">
                    <p>Rechazada</p>
                    <p>20/12/2023</p>
                </div>
                <div class="col-12 postulacion" name="postulacionF" id="postulacionF-N">
                    <p>Finalizada</p>
                    <p>20/12/2023</p>
                </div>
            </div>
        </div>
    </aside>
</section>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
</body>
</html>