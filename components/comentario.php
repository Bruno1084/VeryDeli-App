<?php
function renderComentario ($comentarioId ,$username, $profileIcon, $comFecha, $commentText, $a=false, $idPub=null) {

  ob_start();
?>
  <?php if($a && $idPub!=null){

    ?>
    <div class='publicacionAcotada-container container-fluid shadow border border-dark-subtle rounded my-3' id="comentario_<?php echo$comentarioId; ?>">
      <a class="<?php echo 'text-reset text-decoration-none'?>" href="<?php echo '../pages/publicacion.php?id='.$idPub?>">
        <div class="row p-2 border-bottom">
          <div class="d-flex col-6 mt-1 text-start lh-1">
            <div>
              <img class='profilePicture' src='<?php echo $profileIcon?>' alt='user-icon'>
            </div>
            <div>
              <p><?php echo $username?></p>
            </div>
          </div>
          <div class="col-6 mt-1 text-end lh-1">
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
    <div class='border-top border-bottom my-2 d-flex' id="comentario_<?php echo$comentarioId; ?>">
      <div>
        <img class='profilePicture' src='<?php echo $profileIcon?>' alt='user-icon'>
      </div>
      <div class='text-start col-11'>
        <div class="d-flex col-12 mt-1 text-start lh-1">
          <div class="col-6">
            <p><?php echo $username?></p>
          </div>
          <div class="col-6 mt-1 text-end lh-1">
            <p><?php echo (date('H:i d/m/Y', strtotime($comFecha))) ?></p>
          </div>
        </div>
        <div>
          <p class='comentario-descripcion'><?php echo $commentText?></p>
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
