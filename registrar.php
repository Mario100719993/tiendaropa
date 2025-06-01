<?php
$mensaje = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $host = "localhost";
    $user = "root";
    $password = "M@rio123";
    $database = "MarioStreetwear";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $nombre = $conn->real_escape_string($_POST['nombre']);
    $apellido = $conn->real_escape_string($_POST['apellido']);
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Hashear contraseña

    $sql = "INSERT INTO usuarios (Nombre, Apellido, Email, Usuario, Contraseña)
            VALUES ('$nombre', '$apellido', '$email', '$usuario', '$contrasena')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "<div style='text-align:center; color:green; font-weight:bold;'>Registro exitoso</div>";
    } else {
        $mensaje = "<div style='text-align:center; color:red; font-weight:bold;'>Error al registrarte: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrarse - Mario StreetWear</title>
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: #000000;
            line-height: 1.6;
            padding: 20px;
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

        header h1 {
            font-size: 24px;
        }

        .nav-buttons a {
            text-decoration: none;
            color: white;
            margin-left: 20px;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            background-color: #111;
            border: 1px solid white;
        }

        .nav-buttons a:hover {
            background-color: #fff;
            color: black;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #000;
        }

        .btn-submit {
            background-color: #000;
            color: white;
            padding: 12px 20px;
            width: 100%;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #333;
        }

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Mario StreetWear</h1>
        <div class="nav-buttons">
            <a href="iniciarsesion.html">Iniciar Sesión</a>
            <a href="index.html">Inicio</a>
        </div>
    </header>


    <?php echo $mensaje; ?>
    <div class="form-container">
        <h2>Regístrate</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>
            </div>
            <button type="submit" class="btn-submit">Registrarse</button>
        </form>
    </div>

    <footer>
        &copy; 2025 Mario StreetWear. Todos los derechos reservados.
    </footer>

</body>
</html>