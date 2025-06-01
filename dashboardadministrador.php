<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

// Verificar si el usuario es administrador
if ($_SESSION['rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Mario StreetWear</title>
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

        .titulo {
            text-align: center;
            color: #000;
            font-size: 36px;
            margin: 40px 0 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto 40px;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .alert-admin {
            background-color: #ffcc00;
            color: #000;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .panel-container {
            display: flex;
            justify-content: space-around;
            gap: 20px;
            flex-wrap: wrap;
        }

        .panel {
            background-color: #fafafa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            width: 45%;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .panel:hover {
            transform: translateY(-5px);
        }

        .panel h3 {
            color: #000;
            margin-bottom: 15px;
        }

        .opciones li {
            list-style: none;
            margin: 8px 0;
            color: #333;
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

    <!-- HEADER CON NAVEGACIÓN -->
    <header>
        <!-- Botones de categorías -->
        <div class="nav-categorias">
            <a href="camisetas.php">Camisetas</a>
            <a href="pantalones.php">Pantalones</a>
            <a href="sudaderas.php">Sudaderas</a>
            <a href="ropainterior.php">Ropa Interior</a>
        </div>

        <!-- Botón de cerrar sesión -->
        <div class="nav-buttons">
            <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </header>

    <!-- TÍTULO -->
    <h1 class="titulo">Panel de Administración</h1>

    <!-- CONTENIDO DEL DASHBOARD ADMIN -->
    <div class="container">
        <div class="alert-admin">
            ¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!  
            Estás en el panel de administración.
        </div>

        <div class="panel-container">
            <!-- PANEL DE CLIENTES -->
            <div class="panel">
                <h3>Gestionar Clientes</h3>
                <ul class="opciones">
                    <li>✅ Crear cliente</li>
                    <li>✏️ Modificar cliente</li>
                    <li>🗑️ Eliminar cliente</li>
                </ul>
            </div>

            <!-- PANEL DE PRODUCTOS -->
            <div class="panel">
                <h3>Gestionar Productos</h3>
                <ul class="opciones">
                    <li>➕ Añadir producto</li>
                    <li>✏️ Modificar producto</li>
                    <li>🗑️ Eliminar producto</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

</body>
</html>