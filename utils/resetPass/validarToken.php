<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");

if(isset($_POST["codigo"])){
    session_name("Reset_Pass");
    session_start();
    $codigo=$_POST["codigo"];
    
    if($codigo==$_SESSION["token"]){
        manejarError('true','Verificacion Completa','Redirigiendo para crear una nueva contraseña',"../../components/resetPass/passRecuperacion.php");
    }
    else{
        $_SESSION["attempts"]+=1;
        if($_SESSION["attempts"]==5){
            $_SESSION["token"]="";
        }
        manejarError('false',"Codigo invalido","El codigo ingresado no coincide con el enviado a su correo.</br>Numero de intentos restantes: ".(5-$_SESSION["attempts"]));
    }
}
