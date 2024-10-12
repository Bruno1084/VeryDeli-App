<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/verificarDatos.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/user.php");


if(isset($_POST["pass"])){
    session_start();
    $contrasenia=$_POST["pass"];
    
    if(!verificarDatos('[a-zA-Z0-9$@.\-]{7,100}', $contrasenia)){
        manejarError('false','Contraseña inválida','La contraseña ingresada no coincide con el formato solicitado.');
    }
    else{
        if(!User::emailUserPassExist($_SESSION["email"],$contrasenia)){
            manejarError('false',"Contraseña Invalisa","La contraseña ingresada tiene que ser distinta de la usada anteriormente.");
        }
        else{
            if(User::setEmailUserPass($_SESSION["email"],$contrasenia)){
                session_unset();
                session_destroy();
                manejarError('true','Contraseña modificada','Ya puede iniciar sesion en su cuenta',"../../components/login.php");
            }
            else{
                manejarError('false','Error Inesperado','Ocurrio un error al querer modificar la contraseña');
            }
        }
    }
    
}