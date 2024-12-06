<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php
        session_start();
        $usuarioAutenticado = isset($_SESSION['usuario']); // Comprueba si el usuario está autenticado
    ?>

<header>
    <nav class="navbar">
        <ul class="menu">
        <img src="image/lop1.png" alt="Logo" class="logo">
            <li><a href="paginaprincipal.php">Inicio</a></li>
            <li><a href="servicios.php">Servicios</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="#">Acerca</a></li>
            <li><a href="mapa.php">Ubicación</a></li>
            <?php if (isset($_SESSION['usuario'])): ?>
                <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
                    <li>
                        <a href="#">Panel de administración</a>
                        <ul class="sub-menu">
                            <li><a href="Crud_habitaciones.php">Gestión de Habitaciones</a></li>
                            <li><a href="Crud_usuarios.php">Gestión de Usuarios</a></li>
                            <li><a href="actualizar_reservaciones.php">Ver Reservaciones</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="#">Mi cuenta</a>
                    <ul class="sub-menu">
                        <li><a href="ModificarCuenta.php">Editar perfil</a></li>
                        <li><a href="ReservasUsuarios.php">Mis reservas</a></li>
                        <li><a href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="Login.php">Iniciar sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

    <section class="form-login">
        <h3>Iniciar sesión</h3>

        <form action="IniciarSesion.php" method="POST">
            <label for="usuario">Usuario:</label>
            <input class="controles" type="text" name="usuario" placeholder="Digite su usuario" required>
            <label for="password">Contrase&ntilde;a:</label>
            <input class="controles" type="password" name="contrasena" placeholder="Digite su clave" required>
            <button class="boton" type="submit" name="ingresar">Ingresar</button>
            <p><a href="registrousuario.php">Registrarse</a></p>
        </form>
    </section>

    <div class="redes-sociales">
        <h2>Síguenos en nuestras redes sociales</h2>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
        </div>
    </div>
</body>
</html>
