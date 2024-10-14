<?php
function renderPostComentario ($username, $profileIcon, $idPublicacion) {
  return ("
    <div class='border-top border-bottom my-2 py-1 d-flex'>
      <div>
        <img class='profilePicture' src='$profileIcon' alt='user-icon'>
      </div>
      <div class='text-start w-100'>
        <div>
          <p>$username</p>
        </div>

        <div>
          <form action='/utils/publicarComentario.php' method='post' id='formComentar$idPublicacion' autocomplete='off'>
            <div class='row'>
            <div class='col-9'>
              <input class='comentario-descripcion w-100 border rounded py-1' name='comentario' required type='text' placeholder='Escribe un comentario'>
            </div>
            <div class='col-3'>
              <input type='submit' id='btn-enviar' form='formComentar$idPublicacion' class='btn'></input>
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
?>