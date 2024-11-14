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
    $totalPublicacionesStmt = $conexion->query("SELECT COUNT(publicaciones.publicacion_id) FROM publicaciones LEFT JOIN denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id WHERE publicaciones.usuario_autor=".$_SESSION["id"]." AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')");
    $totalPublicaciones = $totalPublicacionesStmt->fetchColumn();
    $totalComentariosStmt = $conexion->query("SELECT COUNT(comentarios.comentario_id) FROM comentarios LEFT JOIN denuncias_reportadas ON denuncias_reportadas.publicacion_id = comentarios.publicacion_id WHERE comentarios.usuario_id=".$_SESSION["id"]." AND (denuncias_reportadas.publicacion_id IS NULL OR denuncias_reportadas.reporte_activo='3')");
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
                    $foto=array("foto"=>$pOc["usuario_fotoPerfil"],"marco"=>$pOc["usuario_marcoFoto"]);
                    echo renderPublicacionAcotada(
                        $pOc["publicacion_id"],
                        $pOc['usuario_localidad'],
                        $pOc['usuario_usuario'],
                        $foto,
                        $pOc['publicacion_fecha'],
                        $pOc["publicacion_descr"],
                        $pOc["imagen_url"]
                    );
                }
                else{
                    $foto=array("foto"=>$pOc["usuario_fotoPerfil"],"marco"=>$pOc["usuario_marcoFoto"]);
                    echo renderComentario(
                        "",
                        $pOc["comentario_id"],
                        $pOc["usuario_usuario"],
                        $foto,
                        $pOc["comentario_fecha"],
                        $pOc["comentario_mensaje"],
                        $_SESSION["id"],
                        false,
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