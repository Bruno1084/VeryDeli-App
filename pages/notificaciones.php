<!DOCTYPE html>
<html lang="en">
<head>
    <?php require($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");?>
    <?php require_once($_SERVER['DOCUMENT_ROOT']."/components/head.php") ?>
    <link rel="stylesheet" href="../css/notificaciones.css">
    <title>Mi Perfil</title>
</head>
<body>
<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/components/Header.php");
    require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/utils/get/getAllNotificacionesFromUser.php');
?>
<?php
    $notifies=getAllNotificacionesFromUsuario();
?>
<div class="primerDivBody">
    <section class="col-12 notificaciones">
        <div class="col-10 contenedor">
            <?php
                foreach($notifies as $notify){
            ?>
            <div class='notificacion container-fluid shadow <?php if($notify["notificacion_estado"]==1) echo "notiLeido";?> border border-dark-subtle rounded my-3' id="notificacion_<?php echo$notify["notificacion_id"]; ?>">
                <a class="text-reset text-decoration-none" href="<?php echo tipoNotify($notify)?>">
                    <div class="mensaje row p-2 border-bottom">
                        <p class='my-3 w-100 text-start'><?php echo $notify["notificacion_mensaje"]?></p>
                    </div>
                </a>
                <div class="pie row d-flex justify-content-between">
                    <div class="col-auto fechaNotify">
                        <p><?php echo $notify["notificacion_fecha"];?></p>
                    </div>
                    <div class="botones d-flex justify-content-end col-auto my-1 text-end lh-1">
                        <p class="btn border me-3" onclick="estadoNotify(event)"><?php if($notify["notificacion_estado"]==0) echo "leido";else echo "no leido"; ?></p>
                        <p class="btn border" onclick="estadoNotify(event)">Eliminar</p>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>

        </div>
    </section>
</div>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
<script>
    function estadoNotify(e){
        const p=e.target;
        const notify=p.parentNode.parentNode.parentNode;
        var estado=p.textContent;
        var id=notify.id.split("_")[1];
        var form=new FormData();
        form.append("id",id);
        form.append("estado",estado);
        fetch('/utils/actualizarNotify.php', {
            method: 'POST',
            body: form
        })
        .then(respuesta => {
            if (!respuesta.ok) { 
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.text(); 
        })
        .then(text => {
            if (text) { 
                if(text.trim()!="error"){
                    switch(text){
                        case "no leido":p.textContent=text;
                                        notify.classList.add('notiLeido');
                                        break;
                        case "leido":   p.textContent=text;
                                        notify.classList.remove('notiLeido');
                                        break;
                        case "delete":  notify.remove();
                                        break;
                        default:;
                    }
                }
                
            } else {
                throw new Error("Respuesta vacía del servidor");
            }
        })
        .catch(error => {});
    }
</script>
</body>
</html>