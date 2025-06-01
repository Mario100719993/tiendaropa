<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

require 'conexion.php'; // Conexión a la base de datos

// Manejar creación de cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_cliente'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = $conn->real_escape_string($_POST['rol']);

    $sql = "INSERT INTO usuarios (Nombre, Apellido, Email, Usuario, Contraseña, rol) 
            VALUES ('$nombre', '$apellido', '$email', '$usuario', '$contrasena', '$rol')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente creado correctamente');</script>";
    } else {
        echo "<script>alert('Error al crear cliente: " . $conn->error . "');</script>";
    }
}

// Manejar modificación de cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_cliente'])) {
    $idusuario = $conn->real_escape_string($_POST['id_modificar']);
    $nombre = $conn->real_escape_string($_POST['nombre_modificar']);
    $apellido = $conn->real_escape_string($_POST['apellido_modificar']);
    $email = $conn->real_escape_string($_POST['email_modificar']);
    $usuario = $conn->real_escape_string($_POST['usuario_modificar']);
    $rol = $conn->real_escape_string($_POST['rol_modificar']);

    $sql = "UPDATE usuarios SET 
                Nombre = '$nombre', 
                Apellido = '$apellido', 
                Email = '$email', 
                Usuario = '$usuario', 
                rol = '$rol'
             WHERE idusuario = '$idusuario'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente modificado correctamente');</script>";
    } else {
        echo "<script>alert('Error al modificar cliente: " . $conn->error . "');</script>";
    }
}

// Manejar eliminación de cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_cliente'])) {
    $id_eliminar = $conn->real_escape_string($_POST['id_eliminar']);

    $sql = "DELETE FROM usuarios WHERE idusuario = '$id_eliminar'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente eliminado correctamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar cliente');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Clientes - Mario StreetWear</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        header {
            background-color: #000000;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-categorias a {
            text-decoration: none;
            color: white;
            margin-right: 15px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            background-color: transparent;
            border: 1px solid white;
        }

        .nav-categorias a:hover {
            background-color: #fff;
            color: black;
        }

        .nav-buttons a {
            text-decoration: none;
            color: white;
            margin-left: 15px;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            background-color: transparent;
            border: 1px solid white;
        }

        .nav-buttons a:hover {
            background-color: #fff;
            color: black;
        }

        h2 {
            text-align: center;
            color: #000;
            margin-top: 40px;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .boton {
            background-color: #000;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        .boton:hover {
            background-color: #333;
        }

        .seccion {
            margin-bottom: 40px;
        }

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <div class="nav-categorias">
            <a href="camisetas.php">Camisetas</a>
            <a href="pantalones.php">Pantalones</a>
            <a href="sudaderas.php">Sudaderas</a>
            <a href="ropainterior.php">Ropa Interior</a>
        </div>

        <div class="nav-buttons">
            <a href="dashboardadministrador.php">Volver al Panel</a>
        </div>
    </header>

    <h2>Gestionar Clientes</h2>

    <div class="container">

        <!-- SECCIÓN CREAR CLIENTE -->
        <div class="seccion">
            <h3>Crear Nuevo Cliente</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" name="contrasena" required>
                </div>
                <div class="form-group">