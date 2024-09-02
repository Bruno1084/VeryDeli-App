<?php 
  function verificarCamposObligatorios($datos){
    foreach($datos as $dato){
        if(empty($dato)){
            return false;
        }
    }
    return true;
}
?>