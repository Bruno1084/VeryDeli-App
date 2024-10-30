<?php 

  if(isset($_POST["enviado"])){
    $comentario = $_POST['comentario'];
    $pubId = $_POST['publicacion-id'];
    require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/startSession.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');
    $db = new DB();
    $conexion = $db->getConnection();
    $stmtComentario = $conexion->prepare('INSERT INTO comentarios (publicacion_id, usuario_id, comentario_mensaje, comentario_fecha) VALUES (?, ?, ?, ?)');
    $fechaActual = date('Y-m-d H:i:s');
    $stmtComentario->bindParam(1, $pubId, PDO::PARAM_INT);
    $stmtComentario->bindParam(2, $_SESSION['id'], PDO::PARAM_INT);
    $stmtComentario->bindParam(3, $comentario, PDO::PARAM_STR);
    $stmtComentario->bindParam(4, $fechaActual, PDO::PARAM_STR);
    if ($stmtComentario->execute()) {
      header('Location: ../public/index.php');
      $stmtComentario = null;
      $conexion = null;
      exit;
    } else {
      $conexion = null;
      $stmtComentario = null;
      echo'
        <script> alert("Error al publicar el comentario, intente de nuevo más tarde.") <script>
      ';
      exit;
    }
    }