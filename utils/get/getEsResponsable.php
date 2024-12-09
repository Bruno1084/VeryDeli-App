<?php
function getEsResponsable($idUsuario) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/database/conection.php");

    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT calificacion_puntaje
            FROM calificaciones
            WHERE usuario_calificado = ?
            ORDER BY calificacion_fecha DESC
            LIMIT 5";

    $stmt = $conexion->prepare($sql);
    $stmt->bindValue(1, $idUsuario, PDO::PARAM_INT);
    $stmt->execute();  

    $calificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($calificaciones) < 5) {
        $DB = null;
        $stmt = null;
        $conexion = null;
        return false;
    }

    $promedio5 = array_sum(array_column($calificaciones, 'calificacion_puntaje')) / 5;

    if($promedio5 < 80){
      $DB = null;
      $stmt = null;
      $conexion = null;
      return false;
    }

    $ultimas3 = array_slice($calificaciones, 2, 3); 

    $promedioUltimas3 = array_sum(array_column($ultimas3, 'calificacion_puntaje')) / 3;
    if ($promedioUltimas3 < 40) {
        $DB = null;
        $stmt = null;
        $conexion = null;
        return false;
    }

    $DB = null;
    $stmt = null;
    $conexion = null;
    return true;
}
