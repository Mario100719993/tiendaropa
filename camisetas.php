<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Camisetas - Mario StreetWear</title>
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
            max-width: 900px;
            margin: 0 auto 40px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
        <div class="nav-categorias">
            <a href="camisetas.php">Camisetas</a>
            <a href="pantalones.php">Pantalones</a>
            <a href="sudaderas.php">Sudaderas</a>
            <a href="ropainterior.php">Ropa Interior</a>
        </div>

        <div class="nav-buttons">
            <a href="dashboard.php">Volver al Inicio</a>
        </div>
    </header>

    <!-- TÍTULO -->
    <h1 class="titulo">Camisetas</h1>

    <!-- CONTENIDO -->
    <div class="container">
        <p>En esta sección encontrarás nuestras camisetas más exclusivas. Próximamente añadiremos productos.</p>
        <!-- Aquí puedes mostrar productos con PHP -->
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

</body>
</html>