<?php
session_start();

// Datos de conexión
$host = "localhost";
$user = "root";
$password = "M@rio123";
$database = "MarioStreetwear";

// Conexión a la base de datos
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
$usuario = $conn->real_escape_string($_POST['usuario']);
$contrasena = $conn->real_escape_string($_POST['contrasena']);

// Preparar consulta
$sql = "SELECT Usuario, Contraseña, rol FROM usuarios WHERE Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($db_usuario, $db_contrasena, $db_rol);

if ($stmt->num_rows === 1) {
    $stmt->fetch();

    // Verificar contraseña
    if (password_verify($contrasena, $db_contrasena)) {
        // Iniciar sesión
        $_SESSION['usuario'] = $db_usuario;
        $_SESSION['rol'] = $db_rol;

        // Redirigir según el rol
        if ($db_rol === 'admin') {
            header("Location: dashboardadministrador.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
}

$conn->close();
?>