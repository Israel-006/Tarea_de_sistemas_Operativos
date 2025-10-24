<?php

require_once 'config.php'; 
session_start();  

header('Content-Type: application/json');


$correo = trim($_POST['correo'] ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');


if (empty($correo) || empty($contrasena)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos.']);
    exit();
}


$sql = "SELECT id, nombre_completo, contrasena, rol FROM usuarios WHERE correo = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    
    $usuario = $result->fetch_assoc();
    
    
    if (password_verify($contrasena, $usuario['contrasena'])) {
        
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre_completo'];
        $_SESSION['usuario_rol'] = $usuario['rol']; 
        
        
        
        $response = ['success' => true, 'message' => '¡Bienvenido, ' . htmlspecialchars($usuario['nombre_completo']) . '!'];
        
        
        if ($usuario['rol'] === 'admin') {
            $response['redirect'] = 'admin.php';
        }

        echo json_encode($response);

    } else {
        
        echo json_encode(['success' => false, 'message' => 'La contraseña es incorrecta.']);
    }
} else {
    
    echo json_encode(['success' => false, 'message' => 'No se encontró ningún usuario con ese correo.']);
}

$stmt->close();
$conn->close();
?>
