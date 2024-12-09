<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/user.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");

if(isset($_POST["correo"])){
    $correo=filter_var($_POST["correo"],FILTER_SANITIZE_EMAIL);
    
    if(!User::emailExist($correo)){
        manejarError('false',"Correo invalido","El correo ingresado no corresponde con ninguna cuenta existente");
    }
    else{
        session_name("Reset_Pass");
        session_start();
        $_SESSION["email"]=$correo;
        require_once($_SERVER["DOCUMENT_ROOT"]."/utils/resetPass/enviarToken.php");
        enviarToken();
    }
}
