<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/conection.php");
function enviarNotificacion($idUsuario_destino,$mensaje,$fechaActual,$tipoNotify,$idPublicacion_origen=null,$idDenunciado=null){
    if(!isset($db)){
        $db=new DB();
    }
    $connection=$db->getConnection();
    $notificado=false;
    if($idUsuario_destino!=-1){
        $sql="INSERT INTO `notificaciones` (`notificacion_mensaje`, `notificacion_fecha`, `notificacion_tipo`, `usuario_id`";
        if($idPublicacion_origen!=null) $sql.=", `publicacion_id`";
        $sql.=") VALUES (?,?,?,?";
        if($idPublicacion_origen!=null) $sql.=",?";
        $sql.=")";

        $stmt=$connection->prepare($sql);

        $stmt->bindParam(1,$mensaje,PDO::PARAM_STR);
        $stmt->bindParam(2,$fechaActual,PDO::PARAM_STR);
        $stmt->bindParam(3,$tipoNotify,PDO::PARAM_INT);
        $stmt->bindParam(4,$idUsuario_destino,PDO::PARAM_INT);
        if($idPublicacion_origen!=null) $stmt->bindParam(5,$idPublicacion_origen,PDO::PARAM_INT);

        $notificado=$stmt->execute();
    }
    else{
        $sql="SELECT administrador_id FROM administradores";
        $stmt=$connection->prepare($sql);
        $idAdmins=null;
        if($stmt->execute()){
            $res=$stmt->fetchAll(PDO::FETCH_ASSOC);
            if($res){
                $idAdmins=$res;
            }
        }
        if($idAdmins!=null){
            $sql="INSERT INTO `notificaciones` (`notificacion_mensaje`, `notificacion_fecha`, `notificacion_tipo`, `usuario_id`, `publicacion_id`) VALUES ";
            $totalAdmins=0;
            $validAdmins=array();
            for($i=0;$i<sizeof($idAdmins);$i++){
                if($idAdmins[$i]["administrador_id"]!=$_SESSION["id"]&&$idAdmins[$i]["administrador_id"]!=$idDenunciado){
                    if($totalAdmins>0) $sql.=", (?, ?, ?, ?, ?)";
                    else $sql.="(?, ?, ?, ?, ?)";
                    $validAdmins[$totalAdmins]=$idAdmins[$i]["administrador_id"];
                    $totalAdmins++;
                }
            }
            $stmt=$connection->prepare($sql);
            for($i=0;$i<sizeof($validAdmins);$i++){
                $stmt->bindParam((($i*5)+1),$mensaje,PDO::PARAM_STR);
                $stmt->bindParam((($i*5)+2),$fechaActual,PDO::PARAM_STR);
                $stmt->bindParam((($i*5)+3),$tipoNotify,PDO::PARAM_INT);
                $stmt->bindParam((($i*5)+4),$validAdmins[$i],PDO::PARAM_INT);
                $stmt->bindParam((($i*5)+5),$idPublicacion_origen,PDO::PARAM_INT);
                
            }
            $notificado=$stmt->execute();
        }
    }
    $stmt=null;
    $connection=null;
    $db=null;
    return $notificado;
}

function enviarEmailNotificacion($correoDestino, $mensaje){
    try{
        $header=array();
        $header[]='Authorization: Bearer re_fGxfLUby_JSUJpNnFyBnfNXgxmYYSCv34';
        $header[]='Content-Type: application/json';
        $email=array(
            "from"=> "VeryDeli <onboarding@resend.dev>",
            "to"=> $correoDestino,
            "subject"=> "Notificacion",
            "html"=> "<h2 style='font-size: 20px; color: #333;'>".$mensaje."</h2>
                     <p>Ingresa a tu cuenta para ver mas detalles</p>"
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
