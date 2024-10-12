<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");

if(isset($_POST["codigo"])){
    session_start();
    $codigo=$_POST["codigo"];
    
    if($codigo==$_SESSION["token"]){
        manejarError('true','Verificacion Completa','Redirigiendo para crear una nueva contraseña',"../components/passRecuperacion.php");
    }
    else{
        $_SESSION["attempts"]+=1;
        manejarError('false',"Codigo invalido","El codigo ingresado no coincide con el enviado a su correo.</br>Numero de intentos restantes: ".(5-$_SESSION["attempts"]));
    }
    
}