<?php
function renderPublicaciones ($publicaciones) {
    include_once($_SERVER['DOCUMENT_ROOT'] . "/components/publicacionExtendida.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");

    $db = new DB();
    ob_start();

    $userCache = [];
?>
    <div class='container-fluid text-center'>
        <?php
            foreach ($publicaciones as $p) {
                $authorId = $p['usuario_autor'];

                if (isset($userCache[$authorId])) {
                    $user = $userCache[$authorId];
                } else {
                    $user = getUsuario($authorId);

                    $userCache[$authorId] = $user;
                }

                $username = $user['usuario_nombre'] . " " . $user['usuario_apellido'];
                $userLocation = $user['usuario_localidad'];

                echo renderPublicacionExtendida(
                    $p["publicacion_id"],
                    $username,
                    "",
                    $userLocation,
                    $p["publicacion_descr"],
                    $p["publicacion_peso"],
                    $p["publicacion_origen"],
                    $p["publicacion_destino"],
                    ""
                );
            };
        ?>
    </div>
<?php
    return ob_get_clean();
};
?>
