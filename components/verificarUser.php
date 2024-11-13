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
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getUsuario.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
  $usuario=getUsuario($usuarioid);
  ob_start();
?>
    <section class="col-12 cuerpo">
        <aside class="col-2 perfil shadow border border-dark-subtle rounded">
            <div class="perfil_user">
                <div class="col-12 user_name">
                    <h4>Verificacion</h4>
                    <h6><?php echo "Usuario:".$usuario["usuario_nombre"]; ?></h6>
                     <h6><?php echo "Localidad:".$usuario["usuario_localidad"]; ?></h6>
                </div>
            </div>
            <div class="perfil_info">
                <?php 
                    if($estado=0){
                        echo "<p>Estado: sin verificar</p>";
                    }
                ?>
                
            </div>
        </aside>
    </section>
<?php
  return ob_get_clean();
}



