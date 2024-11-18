<?php
function renderDenunciasReportadas () {
    include_once "../components/publicacionAcotada.php";
    include_once "../utils/get/getAllPublicacionesDenunciadasPendientes.php";
    include_once "../utils/get/getAllComentariosDenunciadosPendientes.php";

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; //Limite de publicaciones a mostrar
    $offset = ($pagina - 1) * $limit; // Indica desde que indice comenzar
    
    $db = new DB();
    $conexion = $db->getConnection();

    $publicaciones = getAllPublicacionesDenunciadasPendientes($limit, $offset);
    $publicaciones = getAllComentariosDenunciadosPendientes($limit, $offset);
    $totalPublicacionesStmt = $conexion->query("SELECT COUNT(*) FROM publicaciones JOIN denuncias_reportadas ON denuncias_reportadas.publicacion_id = publicaciones.publicacion_id WHERE publicacion_esActivo='1' AND denuncias_reportadas.publicacion_id IS NOT NULL");
    $totalPublicaciones = $totalPublicacionesStmt->fetchColumn();
    $paginasTotales = ceil($totalPublicaciones / $limit);
    ob_start();
    $db=null;
    $conexion=null;
    $totalPublicacionesStmt=null;
    
?>
    <div class='container-fluid text-center'>
        <?php
            foreach ($publicaciones as $p) {
                if($p["usuario_autor"]!=$_SESSION["id"]){
                    $userLocation = $p['usuario_localidad'];
                    $foto=array("foto"=>$p["usuario_fotoPerfil"],"marco"=>$p["usuario_marcoFoto"]);
                    echo renderPublicacionAcotada(
                        $p["publicacion_id"],
                        $userLocation,
                        $p['usuario_autor'],
                        $p['usuario_usuario'],
                        $foto,
                        $p['publicacion_fecha'],
                        $p["publicacion_descr"],
                        $p["imagen_url"],
                        true
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
