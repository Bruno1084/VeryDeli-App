<?php
function obtenerFoto($fYm){
  if($fYm["foto"]==0 && $fYm["marco"]==0){
    return "<div class='defaultPicture'><img src='../assets/user.png' alt='user'></div>";
  }
  elseif($fYm["foto"]!=0 && $fYm["marco"]==0){
    return "<div class='defaultPicture'><img src='".$fYm["foto"]."' alt='user'></div>";
  }
  elseif($fYm["foto"]==0 && $fYm["marco"]!=0){
    return '<div class="profilePicture">
            <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
            <div class="divFoto"><img src="../assets/user.png" alt="user"></div>
            </div>';
  }
  else{
    return '<div class="profilePicture">
            <div class="fondoFoto"></div><img src="'.$fYm["marco"].'" class="decoFoto'.$fYm["marco"][(strlen($fYm["marco"])-5)].'">
            <div class="divFoto"><img src="'.$fYm["foto"].'" alt="user"></div>
            </div>';
  }
}

function renderPublicacionAcotada ($idPublicacion, $userLocation, $idUsuario, $username, $profileIcon, $date, $TituloPublicacion, $imagen, $denunciada=false) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getAllImagenesFromPublicacion.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getAVGCalificacionesFromUsuario.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/funcionesCalificaciones.php');

  $calificacionUsuario = getAVGCalificacionesFromUsuario($idUsuario);

  ob_start();
?>
<div class='publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3'>
  <a class="text-reset text-decoration-none" href='<?php echo "/pages/publicacion.php?id=". $idPublicacion ?><?php if($denunciada)echo "&denuncia=1";?>'>
    <div class='row p-2 border-bottom' name='publicacion_A' id='publicacion-<?php echo $idPublicacion; ?>_A'>
      <div class='d-flex col-6 mt-1 text-start lh-1 datosUsuario'>
        
        <?php echo obtenerFoto($profileIcon);?>
        <div class="col">
          <div class="d-flex usuario-calificacion">
            <p><?php echo $username; ?></p>
            <?php echo estadoCalif($calificacionUsuario) ?>
            <p class="ps-1"><?php if(is_array($calificacionUsuario))echo round($calificacionUsuario['calificacion_promedio'],1)." (".$calificacionUsuario["calificacion_cantidad"].")"; else echo "0 (0)";?></p>
          </div>

          <div>
            <p><?php echo $userLocation; ?></p>
          </div>
        </div>
      </div>
      <div class='col-6 mt-1 text-end lh-1'>
        <div>
          <p> <?php echo (date('H:i', strtotime($date))) ?> </p>
          <p> <?php echo (date('d/m/Y', strtotime($date))) ?> </p>
        </div>
      </div>
    </div>

    <div >
      <div>
        <h3 class="my-3 text-start"><?php echo $TituloPublicacion ?></h3>
      </div>

      <div class='imgPubli-container border border-dark-3 d-flex flex-wrap justify-content-center'>
        <img class='img u_photo img-fluid' src='<?php echo $imagen ?>' alt='product-image'>
      </div>
    </div>
  </a>
</div>
<?php
  return ob_get_clean();
}
