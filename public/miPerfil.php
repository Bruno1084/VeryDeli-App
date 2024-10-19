
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
    <link rel="stylesheet" href="/css/miPerfil.css">
    <title>Mi Perfil</title>

</head>
<body>
<?php 
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php");
 
   
?>


    <div class='container-fluid text-center cuerpo'>
        <?php
            include_once "../components/perfil.php";
            include_once "../utils/get/getUsuario.php";
            require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); 
            $idUsuario=1;
            $db = new DB();  
            $conexion = $db->getConnection();
            ob_start();
            $info_usuario=getUsuario($idUsuario);
            RenderPerfilUser(
                $info_usuario['usuario_id'],
                    $info_usuario['usuario_nombre'],
                    $info_usuario['usuario_apellido'],
                    $info_usuario['usuario_localidad'],
                    $info_usuario['usuario_correo'],
                    $info_usuario["usuario_contraseña"],
                    $info_usuario['usuario_esResponsable'],
                    $info_usuario['usuario_esActivo'],
                );
        ?>
    </div>


<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
<script src="/js/publicacion.js"></script>
</body>
</html>