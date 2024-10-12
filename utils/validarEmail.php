<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/database/validations/checkEmail.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/enviarToken.php");

if(isset($_POST["correo"])){
    $correo=filter_var($_POST["correo"],FILTER_SANITIZE_EMAIL);
    
    if($correo=="javierochoa159@gmail.com"){
        session_start();
        $_SESSION["email"]=$correo;
        enviarToken();
    }
    else{
        manejarError('false',"Correo invalido","El correo ingresado no corresponde con ninguna cuenta existente");
    }
    
    
}