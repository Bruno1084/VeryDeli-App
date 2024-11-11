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
<<<<<<< HEAD
      <div>
        <form action='/utils/publicarComentario.php' method='post' id='formComentar<?php echo $idPublicacion;?>' autocomplete='off'>
          <div class='row'>
            <div class='col-8 col-md-10'>
              <input class='comentario-descripcion w-100 border rounded py-1' name='comentario' required type='text' placeholder='Escribe un comentario'>
            </div>
            <div class='col-4 col-md-2'>
              <input type='submit' id='btn-enviar' form='formComentar<?php echo $idPublicacion;?>' class='btn'></input>
=======
        <div class='col-12'>
          <form action='/utils/publicarComentario.php' method='post' id='formComentar$idPublicacion' autocomplete='off'>
          <div class='row'>
              <div class='col-10'>
                <textarea class='comentario-descripcion w-100 border rounded p-1' name='comentario' required placeholder='Escribe un comentario'></textarea>
            </div>
              <div class='col-2 boton-postC'>
                <input type='submit' id='btn-enviar' form='formComentar$idPublicacion' class='btn border'></input>
>>>>>>> cba1e4e92d5ec1f1101e8f348a3dfac05b7d03c8
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
