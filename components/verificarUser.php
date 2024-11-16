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
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getFotoUser.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

  $usuario=getUsuario($usuarioid);
  $fotoperfil=getFotoUser($usuarioid);
  ob_start();
?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                
                <div class="VerificacionCard">
                    <!-- Tarjeta Verificacion -->
                    <div class="profile-section">
                        <img src="<?= $fotoperfil?>" alt="Foto de perfil" class="profile-image">
                        <span class="user-name"><?php echo "Usuario:".$usuario["usuario_nombre"]; ?></span>
                        <?php   
                                if($estado==0){
                                echo "<h6>Estado:Sin Verificar</h6>";    
                                }   
                        ?> 
                        <spam><?php echo "Localidad:".$usuario["usuario_localidad"];?></spam>
                    </div>
                    <!-- Foto DNI del usuario -->
                    <div class="id-section">
                        <?php 
                            if(($fotodoc1 || $fotodoc2)!=null){
                                echo "<img src='$fotodoc1' alt='Foto DNI' class='id-image'>";
                                echo "<img src='$fotodoc2' alt='Foto DNI' class='id-image'>";
                            }
                            elseif(($fotoboleta1 || $fotoboleta2)!=null){
                                echo "<img src='$fotoboleta1' alt='Foto DNI' class='id-image'>";
                                echo "<img src='$fotoboleta2' alt='Foto DNI' class='id-image'>";
                            }
                        
                        ?>
                        
                        <div class="button-section">
                            <button class="btn btn-accept">Aceptar</button>
                            <button class="btn btn-reject">Rechazar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<?php
  return ob_get_clean();
}



