<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/functions/startSession.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/utils/patch/actualizarDenuncia.php");
if(isset($_POST["accion"])){
    if($_POST["accion"]=="Permitir"){
        if(actualizarDenuncia($_POST["id"],3,$_POST["tipo"]))
        echo "Permitido";
        else echo "Error";
    }
    elseif($_POST["accion"]=="Eliminar"){
        if(actualizarDenuncia($_POST["id"],2,$_POST["tipo"]))
        echo "Eliminado";
        else echo "Error";
    }
}
else{
    echo "Error";
}