<?php 
function limpiarCadena ($cadena) {
    $cadena = stripslashes($cadena); // Elimina "/"
    $pattern = '/(DROP TABLE|SELECT \* FROM|TRUNCATE TABLE|SHOW TABLES|\<|==|\<?php|\?|\/|--|\:|\;|script|\>|\^|\[|\]|DELETE FROM|INSERT INTO|DROP DATABASE|SHOW DATABASE)/i';
    $cadena =  preg_replace($pattern, '', $cadena);

    $cadena = trim($cadena);
    $cadena = stripslashes($cadena);

    return $cadena;
};
