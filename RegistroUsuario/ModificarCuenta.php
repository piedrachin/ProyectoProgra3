<?php
// Iniciar la sesión al principio
session_start();

// Incluir el archivo de conexión a la base de datos
include("conexion_bd.php");

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no está logueado, redirigir a login
    header("Location: login.php");
    exit();
}

// Obtener el nombre de usuario de la sesión
$usuarioSesion = $_SESSION['usuario'];

// Consultar los datos del usuario desde la base de datos
$sql = "SELECT * FROM datos WHERE usuario1 = ?";
$stmt = $conex->prepare($sql);
if (!$stmt) {
    die("Error en la consulta SQL: " . $conex->error);
}

$stmt->bind_param("s", $usuarioSesion);
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si el usuario existe en la base de datos
if ($resultado->num_rows > 0) {
    // El usuario se encontró, obtener los datos
    $usuario = $resultado->fetch_assoc();
} else {
    // Si no se encuentra el usuario en la base de datos
    echo "Usuario no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil</title>
    <link rel="stylesheet" href="css/editar.css">
</head>

<body>
<header>
    <nav class="navbar">
        <ul class="menu">
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

<div class="contenedor">
    <div class="contenedor-central">
        <div id="ModificarLogin">
            <h2>Modificar perfil</h2>
            <form action="actualizar_datos.php" method="POST">
                <label for="identificacion">Identificación:</label>
                <input type="text" id="identificacion" name="identificacion" value="<?php echo htmlspecialchars($usuario['id']); ?>" readonly>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                <label for="apellidoUno">Primer Apellido:</label>
                <input type="text" id="apellidoUno" name="apellidoUno" value="<?php echo htmlspecialchars($usuario['apellido1']); ?>" required>

                <label for="apellidoDos">Segundo Apellido:</label>
                <input type="text" id="apellidoDos" name="apellidoDos" value="<?php echo htmlspecialchars($usuario['apellido2']); ?>" required>

                <label for="telefono">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>

                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>

                <label for="contrasena">Nueva Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Dejar en blanco para no cambiar">

                <button type="submit" class="btn_actualizar" name="actualizar">Actualizar Datos</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
