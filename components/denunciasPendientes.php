<?php
function renderDenunciasPendientes () {
    include_once $_SERVER["DOCUMENT_ROOT"]."/components/publicacionAcotada.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/components/comentario.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllDenunciasPendientes.php";

    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 10; //Limite de publicaciones a mostrar
    $offset = ($pagina - 1) * $limit; // Indica desde que indice comenzar
    
    $db = new DB();
    $conexion = $db->getConnection();

    $pubYcom = getAllDenunciasPendientes($limit, $offset);
    $totalDenunciasPendientesStmt = $conexion->query("SELECT COUNT(*) FROM denuncias_reportadas WHERE denuncias_reportadas.reporte_activo='1'");
    $totalDenunciasPendientes = $totalDenunciasPendientesStmt->fetchColumn();
    $paginasTotales = ceil($totalDenunciasPendientes / $limit);
    ob_start();
    $db=null;
    $conexion=null;
    $totalDenunciasPendientesStmt=null;
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
                        $pOc["usuario_id"],
                        $pOc['usuario_usuario'],
                        $foto,
                        $pOc['reporte_fecha'],
                        $pOc["publicacion_descr"],
                        $pOc["imagen_url"],
                        true
                    );
                }
                else{
                    $foto=array("foto"=>$pOc["usuario_fotoPerfil"],"marco"=>$pOc["usuario_marcoFoto"]);
                    echo renderComentario(
                        "",
                        $pOc["comentario_id"],
                        $pOc["usuario_usuario"],
                        $foto,
                        $pOc["reporte_fecha"],
                        $pOc["comentario_mensaje"],
                        $pOc["usuario_id"],
                        true,
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