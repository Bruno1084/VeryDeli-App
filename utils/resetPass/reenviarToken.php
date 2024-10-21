<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
if(isset($_POST["reenviar"])){
    session_name("Reset_Pass");
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/resetPass/enviarToken.php");
    enviarToken();
}
else{
    session_unset();
    session_destroy();
    manejarError("false","Error inesperado","Ocurrio un error inesperado al intentar reenviar el codigo de verificacion","../../components/login.php");
}