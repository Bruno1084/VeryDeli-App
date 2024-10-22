<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/manejaError.php");
if(isset($_POST["resetToken"])){
    session_name("Reset_Pass");
    session_start();
    $_SESSION["token"]="";
    $_SESSION["attempts"]=5;

    manejarError("false","Tiempo agotado","El codigo ya no es valido, han pasado mas de 8 minutos.");
}