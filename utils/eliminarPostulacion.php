<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$postulacionId = $data['id'];
$estado = $data['estado'];
$db = new DB();
$conexion = $db->getConnection();

if($estado != "Aceptada"){
    $upPostulacionStmt = $conexion->prepare('UPDATE postulaciones SET postulacion_estado = "3" WHERE postulacion_id = ?');
    $upPostulacionStmt->bindParam(1, $postulacionId, PDO::PARAM_INT);
    $conexion = null;
    if ($upPostulacionStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    $upPostulacionStmt = null;
} else{
    echo json_encode(['success' => false, 'message' => 'Debes rechazar o cancelar una postulacion, antes de eliminarla']);
}


