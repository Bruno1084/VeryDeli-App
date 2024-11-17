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
               <form>
                    <div class="VerificacionCard">
                        <!-- Tarjeta Verificacion -->
                        <div class="profile-section">
                            <?php 
                                if($fotoperfil==false){
                                echo "<img src='/assets/user.png' alt='Foto de perfil' class='profile-image'>";
            
                                }
                                else{
                                    echo"<img src='$fotoperfil' alt='Foto de perfil' class='profile-image'>";
                                }
                            ?>
                            <span class="user-name"><?php echo "Usuario:".$usuario["usuario_nombre"]; ?></span>
                            <?php   
                                    if($estado==0){
                                    echo "<h6>Estado:Sin Verificar</h6>";    
                                    }   
                            ?> 
                            <spam><?php echo "Localidad:".$usuario["usuario_localidad"];?></spam>
                    
                            <spam><?php echo "Tipo de Documento:".$tipodoc?></spam>
                            <spam><?php echo "Tipo de Documento:".$tipoboleta?></spam>
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
                                <!-- 0="pendiente", a 1="aceptado" o 2="rechazado" -->
                                <button type="button" class="btn btn-accept" title="Aceptar" data-estadp="<?= $estado=1 ?>" data-id="<?= $verificacionid ?>" onclick="cambiarEstadoVerificacion(this)">Aceptar</button>
                                <button type="button" class="btn btn-reject" title="Rechazar" data-estadp="<?= $estado=2 ?>" data-id="<?= $verificacionid ?>" onclick="cambiarEstadoVerificacion(this)">Rechazar</button>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>    
<?php
  return ob_get_clean();
}



