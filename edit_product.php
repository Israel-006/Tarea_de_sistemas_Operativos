<?php

session_start();
require_once 'config.php';


if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php');
    exit();
}


if (!isset($_GET['id'])) {
    die("No se especificó un producto para editar.");
}

$id_producto = intval($_GET['id']);


$sql = "SELECT nombre, descripcion, detalles, precio, imagen_url FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Producto no encontrado.");
}
$producto = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Ubuntu', sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px; color: #333; }
        .container { max-width: 800px; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #6a0dad; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="number"], textarea {
            width: 100%; padding: 10px; border: 1px solid #ccc;
            border-radius: 4px; box-sizing: border-box;
        }
        textarea { resize: vertical; min-height: 100px; }
        button {
            background-color: #5cb85c; color: white; padding: 10px 20px;
            border: none; border-radius: 4px; cursor: pointer; font-size: 16px;
        }
        button:hover { background-color: #4cae4c; }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #6a0dad; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Producto</h1>
        <form action="update_product.php" method="POST">
            <!-- Campo oculto para enviar el ID del producto que estamos editando -->
            <input type="hidden" name="id" value="<?php echo $id_producto; ?>">
            
            <div>
                <label for="nombre">Nombre del Producto:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>
            <div>
                <label for="descripcion">Descripción (corta):</label>
                <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            <div>
                <label for="detalles">Información Adicional:</label>
                <textarea id="detalles" name="detalles"><?php echo htmlspecialchars($producto['detalles']); ?></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
            </div>
            <div>
                <label for="imagen_url">URL de la Imagen:</label>
                <input type="text" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($producto['imagen_url']); ?>" required>
            </div>
            <button type="submit">Actualizar Producto</button>
        </form>
        <a class="back-link" href="admin.php">Cancelar y volver al Panel</a>
    </div>
</body>
</html>
