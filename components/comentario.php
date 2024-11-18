<?php
function renderComentario ($comentarioCount, $comentarioId ,$username, $profileIcon, $comFecha, $commentText, $autorComen, $denuncia=false, $a=false, $idPub=null) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getAVGCalificacionesFromUsuario.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/funcionesCalificaciones.php');

  $calificacionUsuario = getAVGCalificacionesFromUsuario($autorComen);


  ob_start();
?>
  <?php
  if($a && $idPub!=null){
  ?>
  <div class='comentario publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3' id="comentario_<?php echo$comentarioId; ?>">
    <a class="text-reset text-decoration-none" href="<?php echo '/pages/publicacion.php?id='.$idPub?><?php if($denuncia)echo "&denuncia=2&comentario=".$comentarioId;?>">
      <div class="row p-2 border-bottom">
        <div class="d-flex col-6 mt-1 text-start lh-1 datosUsuario">

          <?php echo obtenerFoto($profileIcon);?>

          <div class="d-flex usuario-calificacion">
            <p><?php echo $username?></p>
            <?php echo estadoCalif($calificacionUsuario) ?>
          </div>
        </div>
        <div class="dataComentario col-6 mt-1 text-end lh-1">
          <div>
            <p><?php echo (date('H:i', strtotime($comFecha))) ?></p>
            <p><?php echo (date('d/m/Y', strtotime($comFecha))) ?></p>
          </div>
        </div>
      </div>
      <div>
        <div>
          <p class='my-3 text-start'><?php echo $commentText?></p>
        </div>
      </div>
    </a>
  </div>

  <?php
  } 
  else{
  ?>
    <div class='comentario border-top <?php if($denuncia==2) echo "comentario-denunciado";?> border-bottom my-2 d-flex' id="comentario_<?php echo$comentarioCount; ?>" data-id="<?php echo $comentarioId?>">
      
      <?php echo obtenerFoto($profileIcon);?>
      
      <div class='dataComentario text-start col-11'>
        <div class="d-flex col-12 mt-1 text-start lh-1">
          <div class="col-6 mt-1 text-start lh-1">
            <p class="comentario-user"><?php echo $username?></p>
          </div>
          <div class="col-6 mt-1 text-end lh-1">
            <p class="comentario-fecha"><?php echo (date('d/m/Y', strtotime($comFecha))) ?></p>
          </div>
          <?php 
            if(!$denuncia){
              if($_SESSION['id'] == $autorComen){
                echo '
                <div class="dropdown publicacionExtendida-menuButton-container" data-id="autor_'.$autorComen.'" id="menuButton_'.$comentarioCount.'">
                  <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" data-id="autor_'.$autorComen.'" onclick="modificarComentario(event)" >Modificar comentario</a></li>
                    <li><a class="dropdown-item" onclick="eliminarComentario(event)">Eliminar comentario</a></li>
                  </ul>
                </div>';
              }
              else{
                echo '
                <div class="dropdown publicacionExtendida-menuButton-container">
                  <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><button type="button" class="dropdown-item" onclick="reportarComentario('.$comentarioId.')" data-bs-target="#modalReportarComentario" data-bs-toggle="modal">Reportar</button></li>
                  </ul>
                </div>';
              }
            }
          ?>
        </div>
        <div class="d-flex cuerpoComentario">
          <p class='comentario-descripcion col-11' name="newComentario<?php echo $comentarioId;?>"><?php echo $commentText?></p>
          <div>
            <p class="comentario-hora text-end col-1"><?php echo (date('H:i', strtotime($comFecha))) ?></p>
            <?php if(!$denuncia){?>
            <p onclick="actualizarComentario(event)" class="botones-comentario btn inputHidden">Modificar</p>
            <p onclick="cancelarActualizar(event)" class="botones-comentario btn inputHidden">Cancelar</p>
            <?php }?>
          </div>
        </div>
        <?php 
          if($denuncia==2 && $_GET["comentario"]==$comentarioId){
        ?>
        <div class="mb-1 d-flex justify-content-end">
          <div class="resultDenuncia"><p></p></div>
          <button type="button" class="btn procesarDenuncia me-4 btn-outline-success btn-md" data-name="comentario" data-id="<?php echo $comentarioId ?>" onclick="procesarDenuncia(event)">Permitir</button>
          <button type="button" class="btn procesarDenuncia me-5 btn-outline-danger btn-md" data-name="comentario" data-id="<?php echo $comentarioId ?>" onclick="procesarDenuncia(event)">Eliminar</button>
        </div>
        <?php
          }
        ?>
      </div>
      <?php if($a && $idPub!=null) echo "</a>"; ?>
    </div>
  <?php
  }
  ?>
  
<?php
  return ob_get_clean();
}
