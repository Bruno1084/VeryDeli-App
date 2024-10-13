<?php
function renderPublicaciones ($publicaciones) {
    include "../components/publicacionExtendida.php";
    $db = new DB();
    ob_start();

    $userCache = [];
?>
    <div class='container-fluid text-center border border-black'>
        <?php
            foreach ($publicaciones as $p) {
                $authorId = $p['usuario_autor'];

                if (isset($userCache[$authorId])) {
                    $user = $userCache[$authorId];
                } else {
                    $user = $db->getUsuario($authorId);

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
