<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

require 'conexion.php'; // Asegúrate de tener conexion.php

// Manejar creación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_producto'])) {
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $talla = $conn->real_escape_string($_POST['talla']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $imagen = $conn->real_escape_string($_POST['imagen']);

    $sql = "INSERT INTO productos (Nombre, Tipo, Talla, Precio, Imagen) 
            VALUES ('$nombre', '$tipo', '$talla', '$precio', '$imagen')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto creado correctamente');</script>";
    } else {
        echo "<script>alert('Error al crear producto: " . $conn->error . "');</script>";
    }
}

// Manejar modificación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_producto'])) {
    $idproducto = $conn->real_escape_string($_POST['producto_modificar']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $tipo = $conn->real_escape_string($_POST['tipo']);
    $talla = $conn->real_escape_string($_POST['talla']);
    $precio = $conn->real_escape_string($_POST['precio']);
    $imagen = $conn->real_escape_string($_POST['imagen']);

    $sql = "UPDATE productos SET 
                Nombre = '$nombre', 
                Tipo = '$tipo', 
                Talla = '$talla', 
                Precio = '$precio', 
                Imagen = '$imagen'
             WHERE idproducto = '$idproducto'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto modificado correctamente');</script>";
    } else {
        echo "<script>alert('Error al modificar producto: " . $conn->error . "');</script>";
    }
}

// Manejar eliminación de producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_producto'])) {
    $id_eliminar = $conn->real_escape_string($_POST['producto_eliminar']);

    $sql = "DELETE FROM productos WHERE idproducto = '$id_eliminar'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Producto eliminado correctamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar producto');</script>";
    }
}

// Obtener todos los productos para los selectores
$sql_productos = "SELECT idproducto, Nombre, Tipo, Talla, Precio, Imagen FROM productos";
$result_productos = $conn->query($sql_productos);
$productos = [];

while ($row = $result_productos->fetch_assoc()) {
    $productos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Productos - Mario StreetWear</title>
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
        input[type="number"],
        input[type="file"],
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

        .datos-producto {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin-top: 10px;
            display: none;
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

    <h2>Gestionar Productos</h2>

    <div class="container">

        <!-- SECCIÓN CREAR PRODUCTO -->
        <div class="seccion">
            <h3>Añadir Nuevo Producto</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select name="tipo" required>
                        <option value="">-- Selecciona tipo --</option>
                        <option value="Camisetas">Camisetas</option>
                        <option value="Pantalones">Pantalones</option>
                        <option value="Sudaderas">Sudaderas</option>
                        <option value="Ropa Interior">Ropa Interior</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="talla">Talla:</label>
                    <select name="talla" required>
                        <option value="">-- Selecciona talla --</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€):</label>
                    <input type="number" step="0.01" name="precio" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Nombre del archivo de imagen:</label>
                    <input type="text" name="imagen" placeholder="ej: camiseta_negra.jpg">
                </div>
                <button type="submit" name="crear_producto" class="boton">Añadir Producto</button>
            </form>
        </div>

        <!-- SECCIÓN MODIFICAR PRODUCTO -->
        <div class="seccion">
            <h3>Modificar Producto</h3>
            <form method="post" action="" id="form-modificar-producto">
                <div class="form-group">
                    <label for="producto_modificar">Selecciona un producto:</label>
                    <select name="producto_modificar" id="producto_modificar" required>
                        <option value="">-- Selecciona un producto --</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['idproducto'] ?>">
                                <?= htmlspecialchars($producto['Nombre'] . ' (' . $producto['Tipo'] . ', ' . $producto['Talla'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Datos del producto -->
                <div id="datos_producto" class="datos-producto"></div>

                <!-- Campos ocultos que se rellenan dinámicamente -->
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo:</label>
                    <select name="tipo" id="tipo" required>
                        <option value="Camisetas">Camisetas</option>
                        <option value="Pantalones">Pantalones</option>
                        <option value="Sudaderas">Sudaderas</option>
                        <option value="Ropa Interior">Ropa Interior</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="talla">Talla:</label>
                    <select name="talla" id="talla" required>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="precio">Precio (€):</label>
                    <input type="number" step="0.01" name="precio" id="precio" required>
                </div>
                <div class="form-group">
                    <label for="imagen">Nombre del archivo de imagen:</label>
                    <input type="text" name="imagen" id="imagen">
                </div>

                <button type="submit" name="modificar_producto" class="boton">Modificar Producto</button>
            </form>
        </div>

        <!-- SECCIÓN ELIMINAR PRODUCTO -->
        <div class="seccion">
            <h3>Eliminar Producto</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="producto_eliminar">Selecciona un producto:</label>
                    <select name="producto_eliminar" required>
                        <option value="">-- Selecciona un producto --</option>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['idproducto'] ?>">
                                <?= htmlspecialchars($producto['Nombre'] . ' (' . $producto['Tipo'] . ', ' . $producto['Talla'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="eliminar_producto" class="boton">Eliminar Producto</button>
            </form>
        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

    <script>
        // Script para cargar los datos del producto seleccionado
        const productos = <?= json_encode($productos) ?>;
        const selectProducto = document.getElementById('producto_modificar');
        const datosDiv = document.getElementById('datos_producto');
        const nombreInput = document.getElementById('nombre');
        const tipoInput = document.getElementById('tipo');
        const tallaInput = document.getElementById('talla');
        const precioInput = document.getElementById('precio');
        const imagenInput = document.getElementById('imagen');

        selectProducto.addEventListener('change', () => {
            const id = selectProducto.value;

            if (id === "") {
                datosDiv.style.display = 'none';
                return;
            }

            const producto = productos.find(p => p.idproducto == id);

            if (producto) {
                datosDiv.innerHTML = `
                    <strong>Datos actuales:</strong><br>
                    Nombre: ${producto.Nombre}<br>
                    Tipo: ${producto.Tipo}<br>
                    Talla: ${producto.Talla}<br>
                    Precio: €${parseFloat(producto.Precio).toFixed(2)}<br>
                    Imagen: ${producto.Imagen || 'Sin imagen'}
                `;
                datosDiv.style.display = 'block';

                // Rellenar campos del formulario
                nombreInput.value = producto.Nombre;
                tipoInput.value = producto.Tipo;
                tallaInput.value = producto.Talla;
                precioInput.value = parseFloat(producto.Precio).toFixed(2);
                imagenInput.value = producto.Imagen || '';
            }
        });
    </script>

</body>
</html>