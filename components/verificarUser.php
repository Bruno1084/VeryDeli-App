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
    <div class=" col-8 container-fluid d-flex justify-content-center">
        <div class="row col-12">
            <div class="col-12">
               <form>
                    <div class="col-12 VerificacionCard">
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
                            <spam><?php echo "Tipo de Boleta:".$tipoboleta?></spam>
                        </div>
                        <!-- Fotos Documento y Boleta del usuario -->
                        <div class="id-section">
                            <div class='row' id="carouselVerificacion_<?php echo$usuarioid;?>">
                                <div class='col-12'>
                                    <div id="carouselIndicators_<?php echo $usuarioid;?>" class="carousel slide imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-start">
                                        <div class="carousel-indicators">
                                            <?php $documentacion=array($fotodoc1,$fotodoc2,$fotoboleta1,$fotoboleta2);
                                                    $cantFotos=0;
                                            ?>
                                            <?php for ($i = 0; $i < sizeof($documentacion); $i++) { 
                                                    if($documentacion[$i]!=null){ ?>
                                                <button type="button" data-bs-target="#carouselIndicators_<?php echo $usuarioid;?>" data-bs-slide-to=<?php echo $cantFotos ?> <?php if ($cantFotos == 0) echo "class='active'"; ?> <?php if ($cantFotos == 0) echo "aria-current='true'"; ?> aria-label=<?php echo "'Slide " . ($cantFotos + 1) . "'"; ?>></button>
                                            <?php       $cantFotos++;
                                                    } 
                                                    }
                                            ?>
                                        </div>
                                        <div class="carousel-inner">
                                        <?php $cantFotos = 0;
                                            foreach ($documentacion as $fotoDocumentacion) { 
                                                    if($fotoDocumentacion!=null)
                                                    { ?>
                                                        <div class="carousel-item <?php if ($cantFotos == 0) echo "active"; ?>">
                                                        <img class='img u_photo img-fluid id-image' src='<?php echo $fotoDocumentacion; ?>' alt='<?php switch($cantFotos){
                                                                                                                                                            case 0: echo "Foto Documento";
                                                                                                                                                                    break;
                                                                                                                                                            case 1: if($fotodoc2==null) echo "Foto Boleta";
                                                                                                                                                                    else echo "Foto Documento";
                                                                                                                                                                    break;
                                                                                                                                                            case 2: echo "Foto Boleta";
                                                                                                                                                                    break;
                                                                                                                                                            case 3: echo "Foto Boleta";
                                                                                                                                                        }?>'>
                                                        </div>
                                        <?php           $cantFotos++;
                                                    }
                                            } ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators_<?php echo $usuarioid;?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators_<?php echo $usuarioid;?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="button-section">
                                <!-- 0="pendiente", a 1="aceptado" o 2="rechazado" -->
                                <button type="button" class="btn btn-accept" title="Aceptar"  data-id="<?php echo $verificacionid; ?>" data-name="<?php echo $usuarioid;?>" onclick="cambiarEstadoVerificacion(this,1)">Aceptar</button>
                                <button type="button" class="btn btn-reject" title="Rechazar" data-id="<?php echo $verificacionid; ?>" onclick="cambiarEstadoVerificacion(this,2)">Rechazar</button>
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



