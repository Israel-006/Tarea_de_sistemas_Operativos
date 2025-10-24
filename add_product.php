<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso denegado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
 
    $detalles = trim($_POST['detalles'] ?? ''); 
    $precio = trim($_POST['precio']);
    $imagen_url = trim($_POST['imagen_url']);

   
    $sql = "INSERT INTO productos (nombre, descripcion, detalles, precio, imagen_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sssds", $nombre, $descripcion, $detalles, $precio, $imagen_url);
    
    if ($stmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error al añadir el producto: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

