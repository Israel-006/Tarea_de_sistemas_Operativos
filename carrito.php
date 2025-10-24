<?php

session_start();
require_once 'config.php';


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$productos_en_carrito = [];
$subtotal = 0;


if (!empty($_SESSION['carrito'])) {
   
    $ids_productos = implode(',', array_keys($_SESSION['carrito']));
    
    $sql = "SELECT id, nombre, precio, imagen_url FROM productos WHERE id IN ($ids_productos)";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $cantidad = $_SESSION['carrito'][$row['id']];
            $row['cantidad'] = $cantidad;
            $row['total_producto'] = $row['precio'] * $cantidad;
            $productos_en_carrito[] = $row;
            $subtotal += $row['total_producto'];
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - MUYAYOSTIM</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 900px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #6a0dad; }
        .cart-item { display: flex; align-items: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .cart-item img { width: 100px; height: 100px; object-fit: contain; margin-right: 20px; border-radius: 8px; }
        .item-details { flex-grow: 1; }
        .item-details h3 { margin: 0 0 10px 0; }
        .item-price { font-weight: bold; color: #4f46e5; }
        .quantity-selector { display: flex; align-items: center; }
        .quantity-selector input { width: 40px; text-align: center; border: 1px solid #ccc; margin: 0 5px; }
        .quantity-selector a, .quantity-selector button { 
            text-decoration: none; color: #333; background-color: #f2f2f2; 
            padding: 5px 10px; border-radius: 4px; border: 1px solid #ccc;
        }
        .remove-link a { color: #ff4d4d; text-decoration: none; font-size: 0.9em; }
        .cart-summary { text-align: right; margin-top: 30px; }
        .cart-summary h2 { font-size: 1.5em; }
        .checkout-btn { 
            background-color: #5cb85c; color: white; padding: 12px 25px; text-decoration: none;
            border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 10px;
        }
        .empty-cart { text-align: center; padding: 40px 0; }
        .back-link { display: inline-block; margin-top: 20px; color: #6a0dad; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tu Carrito de Compras</h1>
        
        <?php if (empty($productos_en_carrito)): ?>
            <div class="empty-cart">
                <p>Tu carrito está vacío.</p>
                <a href="index.php" class="back-link">Volver a la tienda</a>
            </div>
        <?php else: ?>
            <div id="cart-items">
                <?php foreach ($productos_en_carrito as $producto): ?>
                    <div class="cart-item">
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="item-price">$<?php echo number_format($producto['precio'], 2); ?></p>
                            <div class="quantity-selector">
                                Cantidad: 
                                <a href="actualizar_carrito.php?id=<?php echo $producto['id']; ?>&accion=dec">-</a>
                                <input type="text" value="<?php echo $producto['cantidad']; ?>" readonly>
                                <a href="actualizar_carrito.php?id=<?php echo $producto['id']; ?>&accion=inc">+</a>
                            </div>
                        </div>
                        <div class="item-total">
                            <p>Total: <strong>$<?php echo number_format($producto['total_producto'], 2); ?></strong></p>
                            <p class="remove-link"><a href="eliminar_del_carrito.php?id=<?php echo $producto['id']; ?>">Eliminar</a></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <h2>Subtotal: $<?php echo number_format($subtotal, 2); ?></h2>
                <a href="#" class="checkout-btn">Proceder al Pago</a>
                <a href="index.php" class="back-link">Seguir Comprando</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
