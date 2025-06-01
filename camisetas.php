<?php
require 'conexion.php';

// Obtener solo las camisetas
$sql = "SELECT Nombre, Precio, Imagen FROM productos WHERE Tipo = 'Camisetas'";
$resultado = $conn->query($sql);
?>

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

        .producto-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .producto {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            padding: 15px;
        }

        .producto img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .producto h4 {
            margin: 10px 0 5px;
            color: #000;
        }

        .producto p {
            color: #555;
            font-weight: bold;
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
            <a href="dashboard.php">Volver al Inicio</a>
        </div>
    </header>

    <h2>Camisetas</h2>

    <div class="container">
        <div class="producto-grid">
            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <div class="producto">
                        <img src="<?= !empty($row['Imagen']) ? 'imagenes/' . $row['Imagen'] : 'imagenes/sin_imagen.jpg' ?>" alt="<?= htmlspecialchars($row['Nombre']) ?>">
                        <h4><?= htmlspecialchars($row['Nombre']) ?></h4>
                        <p>€<?= number_format($row['Precio'], 2) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No hay camisetas disponibles.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

</body>
</html>