<!Doctype html>

<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de</title>
    <link rel="stylesheet" href="css/acerca.css">


</head>

<body>
    <header>
        <?php
        session_start();
        $usuarioAutenticado = isset($_SESSION['usuario']);
        ?>
         <nav class="navbar">
            <ul class="menu">
                <li><a href="paginaprincipal.php">Inicio</a></li>
                <li><a href="servicios.php">Servicios</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="acerca.php">Acerca</a></li>
                <?php if (!$usuarioAutenticado): ?>
                    <li><a href="Login.php">Iniciar sesión</a></li>
                <?php else: ?>
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
                <?php endif; ?>
            </ul>
        </nav>
        </header>

    <div id="contenedor">
        <div class="acerca"><br>

            <H2>Acerca de Nosotros</H2><br>

            <p>Convertirnos en el hotel preferido de la región, reconocido por nuestra atención al detalle,
                excelencia en el servicio y nuestro compromiso con la sostenibilidad y la comunidad.
                Buscamos ser un modelo de hospitalidad y contribuir positivamente a la economía y el turismo local.</p>
            <br>
            <br>
            <img src="Image/acerca.png" alt="Logo de Acerca de" class="img_acerca">
        </div>

        <div class="vision"><br>
            <h2>Nuestra Visión</h2><br>
            <p>Convertirnos en el hotel preferido de la región, reconocido por nuestra atención al detalle,
                excelencia en el servicio y nuestro compromiso con la sostenibilidad y la comunidad.
                Buscamos ser un modelo de hospitalidad y contribuir positivamente a la economía y el turismo local.</p>
            <br>
            <br>
            <img src="Image/vision.png" alt="Logo de Vision" class="img_vision">
        </div>

        <div class="mision">
            <br>
            <h2>Nuestra Misión</h2>
            <br>
            <p>Ofrecer a nuestros huéspedes una experiencia de hospedaje que combine confort, calidad y servicio
                excepcional. Nos esforzamos por crear momentos memorables y
                únicos para cada visitante, garantizando que cada aspecto de su estancia supere sus expectativas.</p>
            <br>
            <br>
            <img src="Image/mision.png" alt="Logo de Mision" class="img_mision">
        </div>

    </div>

    <footer class="redes-sociales">
        <h2>Síguenos en nuestras redes sociales</h2>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
        </div>
        <p class="copy">© 2024 Hotel Bitsu. Todos los derechos reservados.</p>
        
    </footer>

</body>

</html>