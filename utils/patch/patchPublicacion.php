<?php
function patchPublicacion ($id, $titulo, $fecha, $descripcion, $volumen, $peso, $nombreRecibe, $telefono, $origen, $destino, $esActivo) {
  include_once($_SERVER['DOCUMENT_ROOT'] . "/utils/get/getPublicacion.php");
  include_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

  $DB = new DB();
  $conexion = $DB->getConnection();

  $fechaStr = date('Y-m-d H:i:s', strtotime($fecha));

  $sql = "UPDATE
            publicaciones
          SET
            publicacion_titulo = ?,
            publicacion_fecha = ?,
            publicacion_descripcion = ?,
            publicacion_volumen = ?,
            publicacion_peso = ?,
            publicacion_nombreRecibe = ?,
            publicacion_telefono = ?,
            publicacion_origen = ?,
            publicacion_destino = ?,
            publicacion_esActivo = ?
          WHERE
            publicacion_id = ?
          ";
  
  $stmt = $conexion->prepare($sql);
  $stmt->bindValue(1, $titulo, PDO::PARAM_STR);
  $stmt->bindValue(2, $fechaStr, PDO::PARAM_STR);
  $stmt->bindValue(3, $descripcion, PDO::PARAM_STR);
  $stmt->bindValue(4, $volumen, PDO::PARAM_STR);
  $stmt->bindValue(5, $peso, PDO::PARAM_STR);
  $stmt->bindValue(6, $nombreRecibe, PDO::PARAM_STR);
  $stmt->bindValue(7, $telefono, PDO::PARAM_STR);
  $stmt->bindValue(8, $origen, PDO::PARAM_INT);
  $stmt->bindValue(9, $destino, PDO::PARAM_INT);
  $stmt->bindValue(10, $esActivo, PDO::PARAM_STR);

  $isExecuted = false;

  if ($stmt->execute()) {
    $isExecuted = true;
  };
  
  $DB = null;
  $conexion = null;
  $stmt = null;

  return $isExecuted;
};
?>
