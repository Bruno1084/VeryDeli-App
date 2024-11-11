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
<section class="col-12 notificaciones">
    <div class="col-10 contenedor">
        <?php
            foreach($notifies as $notify){
        ?>
        <div class='notificacion container-fluid shadow <?php if($notify["notificacion_estado"]==1) echo "notiLeido";?> border border-dark-subtle rounded my-3' id="notificacion_<?php echo$notify["notificacion_id"]; ?>">
            <a class="text-reset text-decoration-none" href="<?php echo tipoNotify($notify)?>">
                <div class="row p-2 border-bottom">
                    <p class='my-3 w-100 text-start'><?php echo $notify["notificacion_mensaje"]?></p>
                </div>
            </a>
            <div class="row p-2">
                <div class="d-flex col-12 mt-1 text-end lh-1">
                    <p onclick="estadoNotify(event)">leido</p>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

    </div>
</section>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
<script>
    async function estadoNotify(e){
        var p=e.target;
        var notify=p.parentNode.parentNode.parentNode.id;
        var res= await actualizarNotify(notify,p);
        console.log(res);
    }
    async function actualizarNotify(notify,p){
        var estado=0;
        if(p.firstChild.nodeValue.trim()=="liedo"){
            estado=1;
        }
        var id=notify.split("_")[1];
        var form=new FormData();
        form.append("id",id);
        form.append("estado",estado);
        return fetch('/utils/actualizarNotify.php', {
          method: 'POST',
          body: form
        })
        .then(respuesta => {
            if (!respuesta.ok) { 
                throw new Error('Error en la solicitud: ' + respuesta.status);
            }
            return respuesta.json(); 
        })
        .then(text => {
            if (text) { 
                const data = text;
                if(data.message.trim()!="error"){
                    return (data.message);
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