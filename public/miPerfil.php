<?php
function renderPerfil () {
    include_once "../components/perfil.php";
    include_once "../utils/get/getUsuario.php"; 

    $db = new DB();
    $conexion = $db->getConnection();
    $info_usuario=getUsuario($idUsuario);
    
   
    ob_start();
    $userCache = [];
?>
    <div class='container-fluid text-center'>
        <?php
           echo RenderPerfilUser(
                    $info_usuario.$id["usuario_id"],
                    $info_usuario.$usuario_nombre,
                    $info_usuario.$usuario_apellido,
                    $info_usuario.$usuario_localidad['usuario_localidad'],
                    $info_usuario.$usuario_correo,
                    $info_usuario.$usuario_contraseña["usuario_contraseña"],
                    $info_usuario.$usuario_esResponsable["usuario_esResponsable"],
                    $info_usuario.$usuario_esActivo["usuario_esActivo"],
                );
        ?>
    </div>

<?php
    return ob_get_clean();
};
?>