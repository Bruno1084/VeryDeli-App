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
    include_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllPostulacionFromUsuario.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getCalificacionesFromUsuario.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/components/publicacionesUser.php");
?>
<?php
    $info_usuario=getUsuario($_SESSION["id"]);
    $info_postulaciones=getAllPostulacionFromUsuario($_SESSION["id"]);
    $promedio=getAVGCalificacionesFromUsuario($_SESSION["id"]);
     function esPost($info_postulaciones){
        if(empty($info_postulaciones)){
            return "1";
        }
        else{
            return "0";
        }         
    }
    function estadoPost($estado){
        if($estado==0){
            return "Pendiente";
        }
        else if($estado==1){
            return "Aceptada";
        }
        else if($estado==2){
            return "Rechazada";
        }
    }
    function esRes($esResponsable){
        if($esResponsable==1){
            return "<p>Responsable</p>";
        }
        else{
            return "<p>No Responsable</p>";
        }
    }
    function estadoCalif($promedio){
        
        if($promedio >= 1 && $promedio < 2){
            return "<img class='img-fluid' src='/assets/rating(1).svg' alt='rate'>";
        }
        else if($promedio >= 2 && $promedio < 3){
            return "<img class='img-fluid' src='/assets/rating(2).svg' alt='rate'>";
        }
        else if($promedio >= 3 && $promedio < 4){
            return "<img class='img-fluid' src='/assets/rating(3).svg' alt='rate'>";
        }
        else if($promedio >= 4 && $promedio < 5){
            return "<img class='img-fluid' src='/assets/rating(4).svg' alt='rate'>";
        }
        else if($promedio >= 5 && $promedio < 6){
            return "<img class='img-fluid' src='/assets/rating(5).svg' alt='rate'>";
        }
        else{
            return "<img class='img-fluid' src='/assets/rating(0).svg' alt='rate'>";
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
                if(esPost($info_postulaciones)==1){
                    echo "<h6>No tiene Postulaciones Activas</h6>";
                }
                else{
                    echo "<h6>Postulaciones</h6>";
                }
             ?>
            </div>
            <div>
                <?php 
                if(esPost($info_postulaciones)==1){
                    echo "<p>sin informacion</p>";
                }
                else{ 
                    foreach($info_postulaciones as $postulacion): 
                    ?>
                        <div class="col-12 postulacion" name="postulacionP" id="postulacionP-N">
                            <a class="text-reset text-decoration-none d-flex" href="<?php echo '../pages/publicacion.php?id='.$postulacion["publicacion_id"] ?>">
                                <p><?php echo estadoPost($postulacion["postulacion_estado"])?></p>
                                <p><?php echo date('H:i d/m/Y', strtotime($postulacion["postulacion_fecha"]))?></p>
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