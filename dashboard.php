<?php
session_start();


if (!isset($_SESSION['usuario'])) {
    header("Location: iniciarsesion.html");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mario StreetWear</title>
    <style>
        
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
            max-width: 600px;
            margin: 0 auto 40px;
            background-image: url('fondo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
            text-align: center;
            position: relative;
            color: white;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 8px;
        }

        h2 {
            color: #fff;
        }

        p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #eee;
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

    
    <header>
        
        <div class="nav-categorias">
            <a href="camisetas.php">Camisetas</a>
            <a href="pantalones.php">Pantalones</a>
            <a href="sudaderas.php">Sudaderas</a>
            <a href="ropainterior.php">Ropa Interior</a>
        </div>

        
        <div class="nav-buttons">
            <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    </header>

    
    <h1 class="titulo">Mario StreetWear</h1>

    
    <div class="container">
        <div class="overlay">
            <h2>¡Bienvenido, <?php echo htmlspecialchars($usuario); ?>!</h2>
            <p>Selecciona una categoría arriba para empezar a comprar.</p>
        </div>
    </div>

    
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

</body>
</html>