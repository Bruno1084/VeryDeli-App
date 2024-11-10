<?php
function renderPostComentario ($idPublicacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
  $idUser = $_SESSION['id'];
  $user = getUsuario($idUser);
  $username = $user['usuario_usuario'];
  $profileIcon = "./assets/face.svg";

  ob_start();
?>
  <div class='border-top border-bottom my-2 py-1 d-flex'>
    <div>
      <img class='profilePicture' src='<?php echo $profileIcon;?>' alt='user-icon'>
    </div>
    <div class='text-start w-100'>
      <div>
        <p><?php echo $username ?></p>
      </div>

      <div>
        <form action='/utils/publicarComentario.php' method='post' id='formComentar<?php echo $idPublicacion;?>' autocomplete='off'>
          <div class='row'>
            <div class='col-9'>
              <input class='comentario-descripcion w-100 border rounded py-1' name='comentario' required type='text' placeholder='Escribe un comentario'>
            </div>
            <div class='col-3'>
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
