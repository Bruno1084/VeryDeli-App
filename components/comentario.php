<?php
function renderComentario ($comentarioCount, $comentarioId ,$username, $profileIcon, $comFecha, $commentText, $autorComen, $autorPubli, $a=false, $idPub=false) {

  ob_start();
?>
  <?php if($a && $idPub!=null){

    ?>
    <div class='comentario publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3' id="comentario_<?php echo$comentarioId; ?>">
      <a class="text-reset text-decoration-none" href="<?php echo '../pages/publicacion.php?id='.$idPub?>">
        <div class="row p-2 border-bottom">
          <div class="d-flex col-6 mt-1 text-start lh-1 datosUsuario">

            <?php echo obtenerFoto($profileIcon);?>

            <div>
              <p><?php echo $username?></p>
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
    <div class='comentario border-top border-bottom my-2 d-flex' id="comentario_<?php echo$comentarioCount; ?>" data-id="<?php echo $comentarioId?>">
      
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
            if($_SESSION['id'] == $autorComen){
              echo '
              <div class="dropdown publicacionExtendida-menuButton-container" data-id="autor_'.$autorComen.'" id="menuButton_'.$comentarioCount.'">
                <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" data-id="autor_'.$autorComen.'" onclick="modificarComentario(event)" >Modificar comentario</a></li>
                  <li><a class="dropdown-item" href="#">Eliminar comentario</a></li>
                </ul>
              </div>';
            }
            elseif($_SESSION["id"]== $autorPubli){
              echo '
              <div class="dropdown publicacionExtendida-menuButton-container">
                <img class="publicacionExtendida-menuIcon" src="/assets/three-dots-vertical.svg" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#">Denunciar comentario</a></li>
                </ul>
              </div>';
            }
          ?>
        </div>
        <div>
          <form class="d-flex" action="/utils/patch/actualizarComentario.php" method="post" id="newComentario<?php echo $comentarioId;?>">
            <p class='comentario-descripcion col-11' name="newComentario<?php echo $comentarioId;?>"><?php echo $commentText?></p>
            <div>
              <p class="comentario-hora text-end col-1"><?php echo (date('H:i', strtotime($comFecha))) ?></p>
              <input type="submit" name="modificar" onclick="actualizarComentario(event)" class="btn inputHidden" value="Modificar"></input>
              <p onclick="cancelarActualizar(event)" class="btn inputHidden">Cancelar</p>
            </div>
          </form>
        </div>
      </div>
      <?php if($a && $idPub!=null) echo "</a>"; ?>
    </div>
  <?php
  }
  ?>
  
<?php
  return ob_get_clean();
}
