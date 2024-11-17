<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$verificacionId = $data['id'];
$estado = $data['estado'];
$db = new DB();
$conexion = $db->getConnection();

$upVerificacionStmt = $conexion->prepare('UPDATE verificaciones SET verificacion_estado = ? WHERE verificacion_id = ?');
$upVerificacionStmt->bindParam(1, $estado, PDO::PARAM_STR);
$upVerificacionStmt->bindParam(2, $verificacionId, PDO::PARAM_INT);


if ($upVerificacionStmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}