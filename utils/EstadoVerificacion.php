<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/database/conection.php');

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$verificacionId = $data['id'];
$estado = $data['estado'];
$usuarioId= $data["usuarioId"];
$db = new DB();
$conexion = $db->getConnection();

$upVerificacionStmt = $conexion->prepare('UPDATE verificaciones SET verificacion_estado = ? WHERE verificacion_id = ?');
$upVerificacionStmt->bindParam(1, $estado, PDO::PARAM_STR);
$upVerificacionStmt->bindParam(2, $verificacionId, PDO::PARAM_INT);


if ($upVerificacionStmt->execute()) {
    $upVerificacionStmt=null;
    if($usuarioId>0){
        $stmt = $conexion->prepare('UPDATE usuarios SET usuario_esVerificado = "1" WHERE usuario_id = ?');
        $stmt->bindParam(1, $usuarioId, PDO::PARAM_INT);
        if($stmt->execute()){
            $stmt = $conexion->prepare('INSERT INTO userMarcoFoto (usuario_id) VALUES (?)');
            $stmt->bindParam(1, $usuarioId, PDO::PARAM_INT);
            if($stmt->execute()){
                $stmt=null;
                $conexion=null;
                $db=null;
                echo json_encode(['success' => true]);
            }
        }
        $stmt=null;
        $conexion=null;
        $db=null;
        echo json_encode(['success' => false]);
    }
    $conexion=null;
    $db=null;
    echo json_encode(['success' => true]);
} else {
    $upVerificacionStmt=null;
    $conexion=null;
    $db=null;
    echo json_encode(['success' => false]);
}
