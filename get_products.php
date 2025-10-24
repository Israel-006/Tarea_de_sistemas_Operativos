<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

try {
    require_once 'config.php';

    $productos = [];
    
     "detalles".
    $sql = "SELECT id, nombre, descripcion, detalles, precio, imagen_url FROM productos ORDER BY id DESC";

    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception("Error en la consulta SQL: " . $conn->error);
    }
    
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    
    $conn->close();

    echo json_encode(['success' => true, 'data' => $productos]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

