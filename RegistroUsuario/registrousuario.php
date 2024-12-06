<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Registro</title>
    <link rel="stylesheet" href="css/registro.css">
    <style>
        .error {
            color: red;
            font-size: 18px;
        }
    </style>
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
            <li><a href="mapa.php">Ubicación</a></li>
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
        <div id="contenedorcentrado">
            <div id="login">
                <h2>Formulario de Registro</h2>
                <form method="POST" action="registro_usuario.php" onsubmit="return validateForm()">
                    <label for="identificacion">Identificación:</label>
                    <input type="text" id="identificacion" name="identificacion" required placeholder="Digite su identificación">
                    <span class="error" id="identificacionError"></span>

                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required placeholder="Escriba su nombre">
                    <span class="error" id="nombreError"></span>

                    <label for="apellidoUno">Primer Apellido:</label>
                    <input type="text" id="apellidoUno" name="apellidoUno" required placeholder="Escriba su apellido">
                    <span class="error" id="apellidoUnoError"></span>

                    <label for="apellidoDos">Segundo Apellido:</label>
                    <input type="text" id="apellidoDos" name="apellidoDos" required placeholder="Escriba su apellido">
                    <span class="error" id="apellidoDosError"></span>

                    <label for="usuario">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" required placeholder="Escriba su nombre de usuario">
                    <span class="error" id="usuarioError"></span>

                    <label for="contrasena">Contraseña:</label>
                    <input type="password" id="contrasena" name="contrasena" required placeholder="Escriba su contraseña">
                    <span class="error" id="contrasenaError"></span>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required placeholder="Digite su teléfono">
                    <span class="error" id="telefonoError"></span>

                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" required placeholder="Escriba su correo electrónico">
                    <span class="error" id="correoError"></span>

                    <button title="Click para enviar" class="button_submit" type="submit" name="registro">Enviar</button>
                    <button title="Click para limpiar" class="button_reset" type="reset">Limpiar</button>
                </form>
            </div>
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

    <script>
        function validateForm() {
            var valido = true;

            // Validar identificación
            var identificacion = document.getElementById("identificacion").value;
            if (!/^\d{9,15}$/.test(identificacion)) {
                document.getElementById("identificacionError").innerText = "Identificación inválida. Debe tener entre 9 y 15 dígitos.";
                valido = false;
            } else {
                document.getElementById("identificacionError").innerText = "";
            }

            // Validar nombre
            var nombre = document.getElementById("nombre").value;
            if (!/^[a-zA-Z\s]+$/.test(nombre)) {
                document.getElementById("nombreError").innerText = "El nombre solo debe contener letras.";
                valido = false;
            } else {
                document.getElementById("nombreError").innerText = "";
            }

            // Validar teléfono
            var telefono = document.getElementById("telefono").value;
            if (!/^\d{8}$/.test(telefono)) {
                document.getElementById("telefonoError").innerText = "Teléfono inválido. Debe tener exactamente 8 dígitos.";
                valido = false;
            } else {
                document.getElementById("telefonoError").innerText = "";
            }

            // Validar correo
            var correo = document.getElementById("correo").value;
            if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(correo)) {
                document.getElementById("correoError").innerText = "Correo electrónico inválido.";
                valido = false;
            } else {
                document.getElementById("correoError").innerText = "";
            }

            return valido; // Solo se enviará si todas las validaciones son correctas
        }
    </script>
</body>
</html>
