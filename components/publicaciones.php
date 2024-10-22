<?php
function renderPublicaciones () {
    include_once "../components/publicacionExtendida.php";
    include_once "../utils/get/getAllPublicaciones.php";

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 5; //Limite de publicaciones a mostrar
    $offset = ($pagina - 1) * $limit; // Indica desde que indice comenzar
    
    $db = new DB();
    $conexion = $db->getConnection();

    $publicaciones = getAllPublicaciones(5, $offset);

    $totalPublicacionesStmt = $conexion->query("SELECT COUNT(*) FROM publicaciones");
    $totalPublicaciones = $totalPublicacionesStmt->fetchColumn();
    $paginasTotales = ceil($totalPublicaciones / $limit);
    ob_start();

    $userCache = [];
?>
    <div class='container-fluid text-center'>
        <?php
            foreach ($publicaciones as $p) {
                
                $userLocation = $p['usuario_localidad'];

                echo renderPublicacionExtendida(
                    $p["publicacion_id"],
                    $p['usuario_usuario'],
                    "",
                    $p['publicacion_fecha'],
                    $userLocation,
                    $p["publicacion_descr"],
                    $p["publicacion_peso"],
                    $p["ubicacion_origen"],
                    $p["ubicacion_destino"],
                    json_decode($p["imagenes"])
                );
            };
        ?>
    </div>


    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $pagina - 1; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            <?php } ?>

            <?php for ($i = 1; $i <= $paginasTotales; $i++) { ?>
                <li class="page-item <?php echo $i == $pagina ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            
            <?php if ($pagina < $paginasTotales) { ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $pagina + 1; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php
    return ob_get_clean();
};
?>
