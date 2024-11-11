<?php

function renderVerificacion(
    $verificacionid, 
    $fotodoc1, 
    $fotodoc2,
    $fotoboleta1,
    $fotoboleta2,
    $tipodoc,
    $tipoboleta,
    $estado,
    $usuarioid
) {
  $contadorComentarios = 0;
  $commentCache = [];
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

  ob_start();
?>
    <section class="col-12 cuerpo">
        <aside class="col-2 perfil shadow border border-dark-subtle rounded">
            <div class="perfil_user">
                <div class="col-12 user_name">
                    <h4>Verificacion:<?php echo $verificacionid ?></h4>
                </div>
            </div>
            <div class="perfil_info">
                <p>fotoDoc1: <?php echo "$fotodoc1" ?></p>
            </div>
            <div class="perfil_calificacion">
            
            </div>
        </aside>
    </section>
<?php
  return ob_get_clean();
}



