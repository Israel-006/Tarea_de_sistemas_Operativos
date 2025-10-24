<?php

session_start();
require_once 'config.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso denegado.");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $detalles = trim($_POST['detalles']);
    $precio = trim($_POST['precio']);
    $imagen_url = trim($_POST['imagen_url']);

    
    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, detalles = ?, precio = ?, imagen_url = ? WHERE id = ?";
    
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sssdsi", $nombre, $descripcion, $detalles, $precio, $imagen_url, $id);
    
    
    if ($stmt->execute()) {
        
        header("Location: admin.php");
        exit();
    } else {
        
        echo "Error al actualizar el producto: " . $conn->error;
    }

    
    $stmt->close();
    $conn->close();
} else {
    
    header("Location: admin.php");
    exit();
}
?>

