
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
    require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); 
    include_once "../components/perfil.php";
    include_once "../utils/get/getUsuario.php";
?>
    <div class='container-fluid text-center cuerpo'>
        <?php
      
            $idUsuario=1;/* Ejemplo de un id forzado para probar  */
            $db = new DB();  
            $conexion = $db->getConnection();
            ob_start();
            $info_usuario=getUsuario($idUsuario);
            echo $info_usuario['usuario_nombre'];/* Prueba para ver si esta tomando los datos */
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