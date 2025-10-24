<?php

session_start();


if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id_producto = intval($_GET['id']);
    $accion = $_GET['accion'];


    if (isset($_SESSION['carrito'][$id_producto])) {
        if ($accion == 'inc') {
            
            $_SESSION['carrito'][$id_producto]++;
        } elseif ($accion == 'dec') {
            
            $_SESSION['carrito'][$id_producto]--;
           
            if ($_SESSION['carrito'][$id_producto] <= 0) {
                unset($_SESSION['carrito'][$id_producto]);
            }
        }
    }
}


header('Location: carrito.php');
exit();
?>
