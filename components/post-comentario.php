<?php
function renderPostComentario ($username, $profileIcon) {
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
          <form action='../utils/publicarComentario.php' method='post'>
            <input class='comentario-descripcion w-100 border rounded py-1' required type='text' placeholder='Escribe un comentario'>
          </form>
        </div>
      </div>
    </div>
  ");
};
?>