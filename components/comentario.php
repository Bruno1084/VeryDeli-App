<?php
function renderComentario ($username, $profileIcon, $commentText) {

  ob_start();
?>
  <div class='border-top border-bottom my-2 d-flex'>
    <div>
      <img class='profilePicture' src='<?php echo $profileIcon?>' alt='user-icon'>
    </div>
    <div class='text-start'>
      <div>
        <p><?php echo $username?></p>
      </div>

      <div>
        <p class='comentario-descripcion'><?php echo $commentText?></p>
      </div>
    </div>
  </div>
<?php
  return ob_get_clean();
};
?>