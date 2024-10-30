<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function enviarNotificacion($idUsuario_destino,$mensaje,$idPublicacion_origen){
    if(isset($db)){
        $db=null;   
    }
    $db=new DB();
    $connection=$db->getConnection();
    $sql="INSERT INTO `notificaciones` (`notificacion_mensaje`, `notificacion_estado`, `usuario_id`, `publicacion_id`) VALUES (?,'0',?,?)";

    $stmt=$connection->prepare($sql);

    $stmt->bindParam(1,$mensaje,PDO::PARAM_STR);
    $stmt->bindParam(2,$idUsuario_destino,PDO::PARAM_INT);
    $stmt->bindParam(3,$idPublicacion_origen,PDO::PARAM_INT);

    $res=$stmt->execute();
    $stmt=null;
    $connection=null;

    return $res;
}

function enviarEmailNotificacion($correoDestino, $mensaje){
    try{
        $header=array();
        $header[]='Authorization: Bearer re_fGxfLUby_JSUJpNnFyBnfNXgxmYYSCv34';
        $header[]='Content-Type: application/json';
        $email=array(
            "from"=> "VeriDeli <onboarding@resend.dev>",
            "to"=> $correoDestino,
            "subject"=> "Recuperacion de contraseña",
            "html"=> "<h2 style='font-size: 20px; color: #333;'>".$mensaje."</h2>"
            );
        $email=json_encode($email);

        $con=curl_init();
        curl_setopt($con,CURLOPT_URL,'https://api.resend.com/emails');
        curl_setopt($con,CURLOPT_POST,true);
        curl_setopt($con,CURLOPT_POSTFIELDS,$email);
        curl_setopt($con,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($con,CURLOPT_HTTPHEADER,$header);
        curl_setopt($con,CURLOPT_SSL_VERIFYPEER,false);
        
        $res=curl_exec($con);
        if(curl_errno($con)){
            return 2;
        }
        else{
            curl_close($con);
            return 1;
        }
    }
    catch(Exception $e){
        return 3;
    }
}