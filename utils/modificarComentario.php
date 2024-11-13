<?php
if(isset($_POST["comentario"])){
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/patch/actualizarComentario.php");
    if(actualizarComentario($_POST["id"],$_POST["comentario"])==1){
        echo "modificado";
    }
    else{
        echo "error";
    }
}
else{
    require_once($_SERVER["DOCUMENT_ROOT"]."/utils/deletes/eliminarComentario.php");
    if(eliminarComentario($_POST["id"])){
        echo "eliminado";
    }
    else{
        echo "error";
    }
}
