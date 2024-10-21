<?php
function enviarToken(){
    try{
        $token=mt_rand(100000,999999);
        $_SESSION["token"]=$token;
        $correo=$_SESSION["email"];

        $header=array();
        $header[]='Authorization: Bearer re_fGxfLUby_JSUJpNnFyBnfNXgxmYYSCv34';
        $header[]='Content-Type: application/json';
        $email=array(
            "from"=> "VeriDeli <onboarding@resend.dev>",
            "to"=> $correo,
            "subject"=> "Recuperacion de contraseña",
            "html"=> "<p>Su código de verificación para crear una nueva contraseña es:</p>
                        <h2 style='font-size: 20px; color: #333;'>".$token."</h2>
                        <p>¡El código solo es válido en los próximos 8 minutos!</p>"
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
            session_unset();
            session_destroy();
            manejarError('false','Error inesperado','Ocurrio un error inasperado al querer recuperar la contraseña',"../../components/login.php");
        }
        else{
            curl_close($con);
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $_SESSION["timeSendEmail"]=date("U");
            $_SESSION["attempts"]=0;
            manejarError('true','Enviando Verificacion','Enviando codigo de verificacion al correo ingresado',"../../components/resetPass/tokenRecuperacion.php");
        }
    }
    catch(Exception $e){
        session_unset();
        session_destroy();
        manejarError('false','Error inesperado','Ocurrio un error inasperado al querer recuperar la contraseña',"../../components/login.php");
    }
}