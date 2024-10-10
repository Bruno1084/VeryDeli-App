<?php
function renderComentario ($username, $profileIcon, $commentText) {
  return ("
    <div class='border-top border-bottom my-2 d-flex'>
      <div>
        <img class='profilePicture' src='$profileIcon' alt='user-icon'>
      </div>
      <div class='text-start'>
        <div>
          <p>$username</p>
        </div>

        <div>
          <p class='comentario-descripcion'>$commentText</p>
        </div>
      </div>
    </div>
  ");
};
?>