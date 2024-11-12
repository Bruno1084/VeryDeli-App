<?php
function renderPostComentario ($username, $profileIcon, $idPublicacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
  $idUser = $_SESSION['id'];
  $user = getUsuario($idUser);
  $username = $user['usuario_usuario'];
  $profileIcon = "./assets/face.svg";

  ob_start();
?>
  <div class='post-comentario border-top border-bottom my-2 py-1 d-flex'>
    <?php obtenerFoto($profileIcon)?>
    <div class="user-post">
      <img class='profilePicture' src='<?php echo $profileIcon;?>' alt='user-icon'>
    </div>
    <div class='dataComentario text-start col-100'>
      <div>
        <p><?php echo $username ?></p>
      </div>
      <div class='col-12'>
        <form action='/utils/publicarComentario.php' method='post' id='formComentar$idPublicacion' autocomplete='off'>
          <div class='row'>
            <div class='col-8 col-md-10'>
              <textarea class='comentario-descripcion w-100 border rounded py-1' name='comentario' required placeholder='Escribe un comentario'></textarea>
            </div>
            <div class='col-4 col-md-2 boton-postC'>
              <input type='submit' id='btn-enviar' form='formComentar<?php echo $idPublicacion;?>' class='btn'></input>
            </div>
            <input type='hidden' name='publicacion-id' value='<?php echo $idPublicacion;?>'>
            <input type='hidden' name='enviado'>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php
  return ob_get_clean();
};
