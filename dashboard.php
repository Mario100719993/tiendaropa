<?php
session_start();

// Si no hay sesión activa, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.html");
    exit();
}

$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mario StreetWear</title>
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

        .container {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h2 {
            color: #000;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- HEADER CON NAVEGACIÓN -->
    <header>
        <!-- Botones de categorías -->
        <div class="nav-categorias">
            <a href="#">Camisetas</a>
            <a href="#">Pantalones</a>
            <a href="#">Sudaderas</a>
            <a href="#">Ropa Interior</a>
        </div>

        <!-- Botón de cerrar sesión -->
        <div class="nav-buttons">
            <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </header>

    <!-- CONTENIDO DEL DASHBOARD -->
    <div class="container">
        <h2>¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h2>
        <p>Rol: <strong><?php echo htmlspecialchars($rol); ?></strong></p>
        <p>Selecciona una categoría arriba para empezar a comprar.</p>
    </div>

</body>
</html>