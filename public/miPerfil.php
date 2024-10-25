
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/head.php") ?>
    <link rel="stylesheet" href="/css/miPerfil.css">
    <title>Mi Perfil</title>

</head>
<body>
<?php 
    require_once($_SERVER['DOCUMENT_ROOT']."/utils/functions/startSession.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Header.php");
    /* require_once($_SERVER["DOCUMENT_ROOT"].'/database/conection.php'); */ 
    include_once "../components/perfil.php";
    include_once "../utils/get/getUsuario.php";
    include_once "../utils/get/getAllPublicacionesFromUsuario.php"; 
?>
    <div class='container-fluid text-center cuerpo'>
        <?php
          /*   $db = new DB();  
            $conexion = $db->getConnection();
            ob_start();  */            /* $idUsuario=1;  */
            if(isset($_SESSION))echo "hola";
            echo "<pre>";

            var_dump($_SESSION);
            
            echo "</pre>";
            $idUsuario=$_SESSION["id"]; 
            $info_usuario=getUsuario($idUsuario);
            $info_publicaciones=getAllPublicacionesFromUsuario($idUsuario);
            
            echo $info_usuario['usuario_nombre'];/* Prueba para ver si esta tomando los datos del usuario  */
            echo $info_publicacion['publicacion_titulo'];/* Prueba para ver si esta tomando los datos de la publicacion */
            RenderPerfilUser(
                    /* Informacion del usuario */
                    $info_usuario['usuario_id'],
                    $info_usuario['usuario_nombre'],
                    $info_usuario['usuario_apellido'],
                    $info_usuario['usuario_localidad'],
                    $info_usuario['usuario_correo'],
                    $info_usuario["usuario_contraseña"],
                    $info_usuario['usuario_esResponsable'],
                    $info_usuario['usuario_esActivo'],
                    /* Informacion de la publicacion */
                    $info_publicacion['publicacion_titulo'],
                    $info_publicacion['publicacion_fecha'],
                    $info_publicacion['publicacion_descr'],
                    $info_publicacion['publicacion_volumen'],
                    $info_publicacion['publicacion_peso'],
                    $info_publicacion['publicacion_nombreRecibe'],
                    $info_publicacion['publicacion_telefono'],
                    $info_publicacion['ubicacion_origen'],
                    $info_publicacion['ubicacion_destino'],
                    $info_publicacion['usuario_autor'],
                    $info_publicacion['usuario_transportista'],
                    $info_publicacion['publicacion_esActivo'], 
                );
        ?>
    </div>


<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/Footer.php") ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . "/components/JS.php") ?>
<script src="/js/publicacion.js"></script>
</body>
</html>