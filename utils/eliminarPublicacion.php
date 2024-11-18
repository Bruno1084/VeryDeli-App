<?php
if(isset($_POST["publicacion_id"])){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/patch/marcarEliminadoPublicacion.php");
    if(marcarEliminadoPublicacion($_POST["publicacion_id"])){
        echo "Eliminado";
    }
    else{
        echo "Error";
    }
}
else{
    echo "Error";
}