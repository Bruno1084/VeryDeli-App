<?php
function renderPubsAndComsUser() {
    include_once $_SERVER["DOCUMENT_ROOT"]."/components/publicacionAcotada.php";
    require_once($_SERVER["DOCUMENT_ROOT"]."/components/comentario.php");
    include_once $_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllPubsAndComsFromUser.php";

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; //Limite de publicaciones a mostrar
    $offset = ($pagina - 1) * $limit; // Indica desde que indice comenzar
    
    $db = new DB();
    $conexion = $db->getConnection();

    $pubYcom = getAllPubsAndComsFromUser($_SESSION["id"],$limit, $offset);
    $totalPublicacionesStmt = $conexion->query("SELECT COUNT(*) FROM publicaciones WHERE usuario_autor=".$_SESSION["id"]);
    $totalPublicaciones = $totalPublicacionesStmt->fetchColumn();
    $totalComentariosStmt = $conexion->query("SELECT COUNT(*) FROM comentarios WHERE usuario_id=".$_SESSION["id"]);
    $totalComentarios = $totalComentariosStmt->fetchColumn();
    $paginasTotales = ceil(($totalComentarios+$totalPublicaciones) / $limit);
    
    $db=null;
    $conexion=null;
    
    ob_start();
    
    $userCache = [];
?>
    <div class='container-fluid text-center'>
        <?php
            foreach ($pubYcom as $pOc) {
                if($pOc["tipo"]=="publicacion"){
                    echo renderPublicacionAcotada(
                        $pOc["publicacion_id"],
                        $pOc['usuario_localidad'],
                        $pOc['usuario_usuario'],
                        "",
                        $pOc['publicacion_fecha'],
                        $pOc["publicacion_descr"],
                        $pOc["imagen_url"]
                    );
                }
                elseif($pOc["tipo"]=="publicacion"){
                    echo renderComentario(
                        $pOc["comentario_id"],
                        $pOc["usuario_usuario"],
                        "",
                        $pOc["comentario_fecha"],
                        $pOc["comentario_mensaje"],
                        true,
                        $pOc["publicacion_id"]
                    );
                }
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
}