<?php
if($_POST["estado"]=="leido"){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/patch/actualizarEstadoNotify.php");
    if(actualizarEstadoNotify($_POST["id"],$_POST["estado"]))
    echo "no leido";
    else echo "leido";
}
elseif($_POST["estado"]=="no leido"){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/patch/actualizarEstadoNotify.php");
    if(actualizarEstadoNotify($_POST["id"],$_POST["estado"]))
    echo "leido";
    else echo "no leido";
}
elseif($_POST["estado"]=="Eliminar"){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/deletes/eliminarNotificacion.php");
    if(eliminarNotificacion($_POST["id"]))
    echo "delete";
    else echo "error";
}