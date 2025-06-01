<?php
session_start(); 


$host = "localhost";
$user = "root";
$password = "M@rio123";
$database = "MarioStreetwear";


$conn = new mysqli($host, $user, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


$usuario = $conn->real_escape_string($_POST['usuario']);
$contrasena = $conn->real_escape_string($_POST['contrasena']);


$sql = "SELECT Usuario, Contraseña, rol FROM usuarios WHERE Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($db_usuario, $db_contrasena, $db_rol);

if ($stmt->num_rows === 1) {
    $stmt->fetch();

    
    if (password_verify($contrasena, $db_contrasena)) {
        
        $_SESSION['usuario'] = $db_usuario;
        $_SESSION['rol'] = $db_rol;

        
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
}

$conn->close();
?>