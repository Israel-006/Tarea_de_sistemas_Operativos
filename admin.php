<?php

session_start();


if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}
require_once 'config.php';


$productos = [];
$sql = "SELECT id, nombre, precio FROM productos ORDER BY id DESC";
$result = $conn->query($sql);
if ($result) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 1000px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1, h2 { text-align: center; color: #6a0dad; }
        .welcome { text-align: right; margin-bottom: 20px; }
        .welcome a { color: #6a0dad; text-decoration: none; font-weight: bold; margin-left: 10px; }
        form { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; min-height: 80px; }
        button { background-color: #6a0dad; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #56088f; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
        .action-links a { text-decoration: none; font-weight: bold; margin-right: 15px; }
        .edit-link { color: #337ab7; }
        .delete-link { color: #ff4d4d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome">
            Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
            <a href="index.php">Volver a Tienda</a>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
        <h1>Panel de Administración</h1>
        <h2>Añadir Nuevo Producto</h2>
        <form action="add_product.php" method="POST">
            <div><label for="nombre">Nombre del Producto:</label><input type="text" id="nombre" name="nombre" required></div>
            <div><label for="descripcion">Descripción (corta):</label><textarea id="descripcion" name="descripcion" required></textarea></div>
            <div><label for="detalles">Información Adicional:</label><textarea id="detalles" name="detalles"></textarea></div>
            <div><label for="precio">Precio:</label><input type="number" id="precio" name="precio" step="0.01" required></div>
            <div><label for="imagen_url">URL de la Imagen:</label><input type="text" id="imagen_url" name="imagen_url" required></div>
            <button type="submit">Añadir Producto</button>
        </form>
        <h2>Productos Existentes</h2>
        <table>
            <thead><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php if (empty($productos)): ?>
                    <tr><td colspan="4" style="text-align:center;">No hay productos.</td></tr>
                <?php else: ?>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                            <td>$<?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?></td>
                            <td class="action-links">
                                <!-- ENLACE DE EDITAR -->
                                <a href="edit_product.php?id=<?php echo $producto['id']; ?>" class="edit-link">Editar</a>
                                <!-- ENLACE DE ELIMINAR -->
                                <a href="delete_product.php?id=<?php echo $producto['id']; ?>" class="delete-link" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

