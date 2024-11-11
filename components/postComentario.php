<?php
function renderPostComentario ($username, $profileIcon, $idPublicacion) {
  require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');

  return ("
    <div class='post-comentario border-top border-bottom my-2 py-1 d-flex'>
      ".obtenerFoto($profileIcon)."
      <div class='dataComentario text-start col-10'>
        <div user-post>
          <p>$username</p>
      </div>
      <div>
        <form action='/utils/publicarComentario.php' method='post' id='formComentar<?php echo $idPublicacion;?>' autocomplete='off'>
          <div class='row'>
            <div class='col-8 col-md-10'>
              <input class='comentario-descripcion w-100 border rounded py-1' name='comentario' required type='text' placeholder='Escribe un comentario'>
            </div>
            <div class='col-4 col-md-2'>
              <input type='submit' id='btn-enviar' form='formComentar<?php echo $idPublicacion;?>' class='btn'></input>
            </div>
              <input type='hidden' name='publicacion-id' value='$idPublicacion'>
            <input type='hidden' name='enviado'>
          </div>
        </form>
      </div>
    </div>
  </div>
  ");
};
