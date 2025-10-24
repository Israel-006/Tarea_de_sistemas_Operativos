<?php

session_start();
require_once 'config.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    die("Acceso denegado.");
}


if (isset($_GET['id'])) {
    
    $id_producto = intval($_GET['id']);

    
    $sql = "DELETE FROM productos WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    
    
    $stmt->execute();

    $stmt->close();
    $conn->close();
}


header("Location: admin.php");
exit();
?>

