<?php
function actualizarEstadoNotify($id, $estado) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $boolEstado=0;
  if($estado=="leido"){
    $boolEstado=1;
  }

  $DB = new DB();
  $conexion = $DB->getConnection();

  $sql = "UPDATE
            notificaciones
          SET
            notificacion_estado = ?
          WHERE
            notificacion_id = ?
          ";
  
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $boolEstado, PDO::PARAM_INT);
  $stmt->bindValue(2, $id, PDO::PARAM_INT);

  $res=$stmt->execute();

  $DB = null;
  $conexion = null;
  $stmt = null;

  return $res;
}