<?php
function guardarUbicacion($connection,string $ubicacion){
    $sql="INSERT INTO `ubicaciones` (`ubicacion_latitud`, `ubicacion_longitud`, `ubicacion_barrio`, `ubicacion_manzana-piso`, `ubicacion_casa-depto`) VALUES (?, ?, ?, ?, ?)";
    $stmtUbicacion= $connection->prepare($sql);
    $stmtUbicacion->bindParam(1, explode(",",$_POST[$ubicacion."_coordenadas"])[0], PDO::PARAM_STR_NATL);
    $stmtUbicacion->bindParam(2, explode(",",$_POST[$ubicacion."_coordenadas"])[1], PDO::PARAM_STR_NATL);
    $stmtUbicacion->bindParam(3, $_POST[$ubicacion."_barrio"], PDO::PARAM_STR);
    $stmtUbicacion->bindParam(4, $_POST[$ubicacion."_manzana-piso"], PDO::PARAM_STR);
    $stmtUbicacion->bindParam(5, $_POST[$ubicacion."_casa-depto"], PDO::PARAM_STR);

    if($stmtUbicacion->execute()) $idUbicacion=$connection->lastInsertId();
    else {
        $idUbicacion=null;
    }
    $stmtUbicacion=null;
    $connection=null;

    return $idUbicacion;
}
