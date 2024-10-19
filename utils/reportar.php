<?php 
    if (isset($_POST["reporteEnviado"])) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/utils/functions/manejaError.php');
        if(empty($_POST['motivo'])){
            manejarError('false', 'Motivo invalido', 'El motivo del reporte es obligatorio');
            exit;
        }
        $publicacion = $_POST['publicacion-id'];
        manejarError('true', 'Denuncia Registrada', 'Pronto estaremos revisando tu denuncia publicacion denunciada: '.$publicacion);
        exit;
    }
