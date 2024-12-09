<?php
function verificarDatos ($filtro, $dato) {
    if (preg_match("/^".$filtro."$/", $dato)) {
        return false;   // Si la cadena no contiene errores retorna false
    } else {
        return true;    // Si la cadena contiene errores retorna true
    };
};
