<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

require 'conexion.php';

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
    $idusuario = $conn->real_escape_string($_POST['cliente_modificar']);
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $rol = $conn->real_escape_string($_POST['rol']);

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
    $id_eliminar = $conn->real_escape_string($_POST['cliente_eliminar']);

    $sql = "DELETE FROM usuarios WHERE idusuario = '$id_eliminar'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cliente eliminado correctamente');</script>";
    } else {
        echo "<script>alert('Error al eliminar cliente');</script>";
    }
}

// Obtener todos los clientes para los select
$sql_clientes = "SELECT idusuario, Nombre, Apellido, Usuario, Email, rol FROM usuarios";
$result_clientes = $conn->query($sql_clientes);
$clientes = [];

while ($row = $result_clientes->fetch_assoc()) {
    $clientes[] = $row;
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

        .datos-cliente {
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
                    <label for="rol">Rol:</label>
                    <select name="rol" required>
                        <option value="cliente">Cliente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <button type="submit" name="crear_cliente" class="boton">Crear Cliente</button>
            </form>
        </div>

        <!-- SECCIÓN MODIFICAR CLIENTE -->
        <div class="seccion">
            <h3>Modificar Cliente</h3>
            <form method="post" action="" id="form-modificar">
                <div class="form-group">
                    <label for="cliente_modificar">Selecciona un cliente:</label>
                    <select name="cliente_modificar" id="cliente_modificar" required>
                        <option value="">-- Selecciona un cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['idusuario'] ?>">
                                <?= htmlspecialchars($cliente['Nombre'] . ' ' . $cliente['Apellido'] . ' (' . $cliente['Usuario'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Datos del cliente -->
                <div id="datos_cliente" class="datos-cliente"></div>

                <!-- Campos ocultos que se rellenan dinámicamente -->
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" id="usuario" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol:</label>
                    <select name="rol" id="rol" required>
                        <option value="cliente">Cliente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>

                <button type="submit" name="modificar_cliente" class="boton">Modificar Cliente</button>
            </form>
        </div>

        <!-- SECCIÓN ELIMINAR CLIENTE -->
        <div class="seccion">
            <h3>Eliminar Cliente</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label for="cliente_eliminar">Selecciona un cliente:</label>
                    <select name="cliente_eliminar" required>
                        <option value="">-- Selecciona un cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['idusuario'] ?>">
                                <?= htmlspecialchars($cliente['Nombre'] . ' ' . $cliente['Apellido'] . ' (' . $cliente['Usuario'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="eliminar_cliente" class="boton">Eliminar Cliente</button>
            </form>
        </div>

    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

    <script>
        // Script para cargar los datos del cliente seleccionado
        const clientes = <?= json_encode($clientes) ?>;
        const select = document.getElementById('cliente_modificar');
        const datosDiv = document.getElementById('datos_cliente');
        const nombreInput = document.getElementById('nombre');
        const apellidoInput = document.getElementById('apellido');
        const emailInput = document.getElementById('email');
        const usuarioInput = document.getElementById('usuario');
        const rolInput = document.getElementById('rol');

        select.addEventListener('change', () => {
            const id = select.value;

            if (id === "") {
                datosDiv.style.display = 'none';
                return;
            }

            const cliente = clientes.find(c => c.idusuario == id);

            if (cliente) {
                datosDiv.innerHTML = `
                    <strong>Datos actuales:</strong><br>
                    Nombre: ${cliente.Nombre}<br>
                    Apellido: ${cliente.Apellido}<br>
                    Email: ${cliente.Email}<br>
                    Usuario: ${cliente.Usuario}<br>
                    Rol: ${cliente.rol}
                `;
                datosDiv.style.display = 'block';

                // Rellenar campos del formulario
                nombreInput.value = cliente.Nombre;
                apellidoInput.value = cliente.Apellido;
                emailInput.value = cliente.Email;
                usuarioInput.value = cliente.Usuario;
                rolInput.value = cliente.rol;
            }
        });
    </script>

</body>
</html>