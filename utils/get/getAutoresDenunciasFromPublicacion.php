<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");

function getAutoresDenunciasFromPublicacion($idPublicacion){
    $DB = new DB();
    $conexion = $DB->getConnection();

    $sql = "SELECT usuario_autor FROM denuncias_reportadas WHERE publicacion_id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(1,$idPublicacion,PDO::PARAM_INT);
    $stmt->execute();

    $autors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!empty($autors)){
        $aux=array();
        foreach($autors as $autor){
            $aux[]=$autor["usuario_autor"];
        }
        $autors=$aux;
    }

    $DB = null;
    $stmt = null;
    $conexion = null;

    return $autors;
}
