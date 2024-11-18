<?php
function renderPostComentario ($username, $profileIcon, $idPublicacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/get/getUsuario.php');
  

  ob_start();
?>
  <div class='post-comentario border-top border-bottom my-2 py-1 d-flex'>
    
    <?php echo obtenerFoto($profileIcon)?>

    <div class='dataComentario text-start col-10'>
      <div>
        <p><?php echo $username ?></p>
      </div>
      <div class='col-12'>
        <form action='/utils/publicarComentario.php' method='post' id='formComentar<?php echo $idPublicacion;?>' autocomplete='off'>
          <div class='row'>
            <div class='col-8 col-md-10'>
              <textarea class='comentario-descripcion w-100 border rounded py-1' name='comentario' required placeholder='Escribe un comentario'></textarea>
            </div>
            <div class='col-4 col-md-2 boton-postC'>
              <input type='submit' id='btn-enviar' form='formComentar<?php echo $idPublicacion;?>' class='btn border'></input>
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
