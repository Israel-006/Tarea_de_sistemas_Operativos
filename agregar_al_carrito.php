<?php

session_start();


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


if (isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);


    if (isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto]++;
    } else {
        $_SESSION['carrito'][$id_producto] = 1;
    }
}


$total_items = count($_SESSION['carrito']);

header('Content-Type: application/json');
echo json_encode(['success' => true, 'total_items' => $total_items]);
?>
