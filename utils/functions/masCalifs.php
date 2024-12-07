<?php
    require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/get/getAllCalificacionesFromUsuario.php");
    if(isset($_POST["more"])){
        $idUser=$_POST["idUser"];
        $limit=$_POST["limit"];
        $offset=$_POST["offset"];
        $filtro=$_POST["filtro"];
        $orden=$_POST["orden"];
        $stars=$_POST["stars"];

        $mensajesCalif=getAllCalificacionesFromUsuario($idUser,$limit,$offset,$orden,$filtro,$stars);
        echo json_encode($mensajesCalif);
        exit();
    }else{
        $idUser=$_POST["idUser"];
        $limit=$_POST["limit"];
        $offset=$_POST["offset"];
        $filtro=$_POST["filtro"];
        $orden=$_POST["orden"];
        $stars=$_POST["stars"];

        $db=new DB();
        $conexion=$db->getConnection();
        $sql="SELECT COUNT(*) 
              FROM calificaciones 
              WHERE usuario_calificado = $idUser AND calificacion_mensaje IS NOT NULL";
        if($filtro==1)$sql.=" AND calificacion_tipo='1'";
        elseif($filtro==2)$sql.=" AND calificacion_tipo='2'";
        if($stars){
            switch($stars){
                case 1: $sql.=" AND calificacion_puntaje='1'";
                        break;
                case 2: $sql.=" AND calificacion_puntaje='2'";
                        break;
                case 3: $sql.=" AND calificacion_puntaje='3'";
                        break;
                case 4: $sql.=" AND calificacion_puntaje='4'";
                        break;
                case 5: $sql.=" AND calificacion_puntaje='5'";
                        break;
            }
        }
        $totalMensajesCalifStmt = $conexion->query($sql);
        $totalMensajesCalif = $totalMensajesCalifStmt->fetchColumn();
        $totalMensajesCalifStmt=null;
        $coneccion=null;
        $db=null;

        $mensajesCalif=getAllCalificacionesFromUsuario($idUser,$limit,$offset,$orden,$filtro,$stars);
        $Respuesta=array("mensajes"=>$mensajesCalif,"totalMensajes"=>$totalMensajesCalif);
        echo json_encode($Respuesta);
        exit();

    }
