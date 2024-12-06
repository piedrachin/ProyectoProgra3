<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctenos</title>
    <link rel="stylesheet" href="css/contacto.css">
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
        <li><a href="#">Acerca</a></li>
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

<form id="contactForm" action="https://formsubmit.co/petatron2020@gmail.com" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required placeholder="Digite su nombre">

    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required placeholder="Digite su correo electrónico">

    <label for="mensaje">Mensaje:</label>
    <textarea id="mensaje" name="mensaje" rows="5" required placeholder="Deje su reseña o consulta..."></textarea>

    <label for="calificacion">Calificación del sitio (1-5):</label>
    <input type="number" id="calificacion" name="calificacion" min="1" max="5" required placeholder="Califique su experiencia">

    <button type="submit">Enviar</button>
    <button type="reset" style="background-color: #c82333;">Eliminar</button>
    <input type="hidden" name= "_next" value="http://localhost/ProyectoProgra3/RegistroUsuario/contacto.php">
    <input type="hidden" name= "_captcha" value="false">

</form>


<p id="successMessage" style="display: none; color: rgb(3, 49, 3);">¡Gracias por su mensaje! Nos pondremos en contacto pronto.</p>

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

