<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/enviarToken.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
if(isset($_POST["reenviar"])){
    session_start();
    enviarToken();
}
else{
    manejarError("false","Error inesperado","Ocurrio un error inesperado al intentar reenviar el codigo de verificacion");
}