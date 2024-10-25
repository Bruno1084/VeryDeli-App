<?php
    function renderPostulaciones($idPublicacion){
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getAllPostulacionesFromPublicacion.php");
        require_once($_SERVER["DOCUMENT_ROOT"]. "/utils/get/getUsuario.php");
        $postulaciones = getAllPostulacionesFromPublicacion($idPublicacion);
        ob_start();
    ?>
    <section>
    <aside class="col-3">
            <div class="col-12 postulaciones">
                <div class="col-12 postulacion_titulo">
                    <h3>Postulaciones</h3>
                </div>
                <?php 
                    foreach($postulaciones as $postulacion) {
                ?>
                <div>
                  <div class="col-12 postulacion d-flex justify-content-center align-items-center" name="postulacion <?= $nombreUsuario ?>" id="postulacionP-<?= $nombreUsuario ?>">
                    <?php $usuario = getUsuario($postulacion['usuario_postulante']) ?>
                    <div class="row">
                        <div class="col-6">
                            <span> <?= $usuario['usuario_nombre'] ?></span>
                            <span> <?= $postulacion['postulacion_precio'] ?> </span> 
                            <p> <?= $postulacion['postulacion_descr'] ?> </p>
                        </div>
                        <div class="btn-aceptar-rechazar col-6">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-outline" title="Aceptar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"></path>
                                </svg>
                                <span class="visually-hidden">Aceptar</span>
                                </button> 
                                <button type="button" class="btn btn-danger btn-outline" title="Rechazar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"></path>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                                </svg>
                                <span class="visually-hidden">Button</span>
                                </button>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <?php }; ?>
            </div>
        </aside>
  </section>
<?php
    return ob_get_clean();
    };
?>