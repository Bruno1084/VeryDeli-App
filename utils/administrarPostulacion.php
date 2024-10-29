<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$postulacionId = $data['id'];
$publicacion = $data['publicacionId'];
$estado = $data['estado'];
$db = new DB();
$conexion = $db->getConnection();

$upPostulacionStmt = $conexion->prepare('UPDATE postulaciones SET postulacion_estado = ? WHERE postulacion_id = ?');
$upPostulacionStmt->bindParam(1, $estado, PDO::PARAM_STR);
$upPostulacionStmt->bindParam(2, $postulacionId, PDO::PARAM_INT);

if($estado == '1'){
    $transportista = $conexion->query("SELECT usuario_postulante FROM postulaciones WHERE postulacion_id = $postulacionId")->fetch();
    $upPublicacionEstadoStmt = $conexion->prepare("UPDATE publicaciones SET publicacion_esActivo = '2', usuario_transportista = ? WHERE publicacion_id = ?");
    $upPublicacionEstadoStmt->bindParam(1, $transportista['usuario_postulante'], PDO::PARAM_INT);
    $upPublicacionEstadoStmt->bindParam(2, $publicacion, PDO::PARAM_INT);
    $upPublicacionEstadoStmt->execute();
}

if ($upPostulacionStmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
