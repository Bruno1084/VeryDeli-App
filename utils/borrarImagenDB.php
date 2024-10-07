<?php
    function borrarImagenDB($imagen_delete_url) {
    require_once('../database/conection.php');
    $db = new DB();
    $conexion = $db->getConnection();

    $sql = "DELETE FROM `imagenes` WHERE `imagen_delete_url`= ?";
    $stmt->bindParam(1, $imagen_delete_url, PDO::PARAM_INT);
    $stmt = $conexion->prepare($sql);

    $response=$stmt->execute();
    $stmt = null;
    $conexion = null;
    
    if($response){
        require_once("../utils/borrarImagenImgBB.php");
        $response=borrarImagenImgBB($delete_url);
        if(!$response)return 2;    
    }
    else return 1;
  }