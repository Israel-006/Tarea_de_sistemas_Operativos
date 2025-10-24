<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php'; 

header('Content-Type: application/json');


$nombre = trim($_POST['nombre_completo'] ?? '');
$correo = trim($_POST['correo'] ?? '');
$contrasena = trim($_POST['contrasena'] ?? '');
$rol = 'cliente'; 


if (empty($nombre) || empty($correo) || empty($contrasena)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos.']);
    exit();
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'El formato del correo no es válido.']);
    exit();
}


$sql_check = "SELECT id FROM usuarios WHERE correo = ? LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $correo);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Este correo electrónico ya está registrado.']);
    $stmt_check->close();
    $conn->close();
    exit();
}
$stmt_check->close();


$contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql_insert = "INSERT INTO usuarios (nombre_completo, correo, contrasena, rol) VALUES (?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("ssss", $nombre, $correo, $contrasena_hash, $rol);

if ($stmt_insert->execute()) {
    echo json_encode(['success' => true, 'message' => '¡Registro exitoso! Ahora puedes iniciar sesión.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario. Inténtalo de nuevo.']);
}

$stmt_insert->close();
$conn->close();
?>

