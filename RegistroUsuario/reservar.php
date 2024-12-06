<?php
require_once "conexion_bd.php";
session_start();
$usuarioAutenticado = isset($_SESSION['usuario']); // Comprueba si el usuario está autenticado

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Debes iniciar sesión para realizar una reservación. <a href='login.php'>Iniciar sesión</a></p>";
    exit();
}

// Verificar si se seleccionó una habitación
if (!isset($_GET['codigo_habitacion'])) {
    echo "<p>No se seleccionó una habitación. <a href='servicios.php'>Volver a servicios</a></p>";
    exit();
}

$codigo_habitacion = htmlspecialchars($_GET['codigo_habitacion']);

// Obtener información de la habitación seleccionada
$sql = "SELECT * FROM habitaciones WHERE codigo = ?";
$stmt = $conex->prepare($sql);
$stmt->bind_param("s", $codigo_habitacion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>La habitación seleccionada no existe. <a href='servicios.php'>Volver a servicios</a></p>";
    exit();
}

$habitacion = $result->fetch_assoc();
$stmt->close();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_reserva = 'RES-' . rand(100000, 999999);
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario autenticado
    $fechainicio = $_POST['fechainicio'];
    $fechasalida = $_POST['fechasalida'];
    $fechareserva = date('Y-m-d'); // Fecha de la reservación
    $estado = 'pendiente'; // Estado inicial de la reservación

    // Insertar reservación en la base de datos
    $sql_insert = "INSERT INTO reservaciones (id_reserva, codigo_habitacion, usuario_id, fechainicio, fechasalida, estado, fechareserva) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conex->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $id_reserva, $codigo_habitacion, $usuario_id, $fechainicio, $fechasalida, $estado, $fechareserva);

    if ($stmt_insert->execute()) {
        echo "<p>Reservación realizada exitosamente. <a href='historial_reservas.php'>Ver historial</a></p>";
    } else {
        echo "<p>Error al realizar la reservación. Intente nuevamente.</p>";
    }

    $stmt_insert->close();
    $conex->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Habitación</title>
    <link rel="stylesheet" href="css/reservaciones.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="contenedor">
            <img src="image/lop1.png" alt="Logo">
            <a href="paginaprincipal.php">Inicio</a>
            <a href="servicios.php">Servicios</a>
            <a href="#">Contacto</a>
            <a href="#">Acerca</a>
            <?php if (!$usuarioAutenticado): ?>
                    <!-- Mostrar el enlace "Iniciar sesión" solo si el usuario no está autenticado -->
                    <a href="Login.php">Iniciar sesión</a>
                <?php else: ?>
                    <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
        <!-- Mostrar opciones adicionales solo si el usuario es administrador -->
        <a href="Crud_habitaciones.php">Gestión de Habitaciones</a>
        <a href="Crud_usuarios.php">Panel de Administración</a>
        <a href="actualizar_reservaciones.php">Panel de Administración</a>

    <?php endif; ?>
                    <!-- Si el usuario está autenticado, mostrar "Editar perfil" y "Cerrar sesión" -->
                    <a href="ModificarCuenta.php" id="linkEditarPerfil">Editar perfil</a>
                    <a href="logout.php" id="cerrarSesion">Cerrar sesión</a>
                <?php endif; ?>

            <?php if (!$usuarioAutenticado): ?>
                <!-- Mostrar el enlace "Iniciar sesión" solo si el usuario no está autenticado -->
                <a href="Login.php">Iniciar sesión</a>
            <?php else: ?>
                <!-- Si el usuario está autenticado, mostrar "Editar perfil" y "Cerrar sesión" -->
                <a href="ModificarCuenta.php" id="linkEditarPerfil">Editar perfil</a>
                <a href="logout.php" id="cerrarSesion">Cerrar sesión</a>
            <?php endif; ?>
        </div>
    </nav>
    </header>


    <div class="contenedor-centrado">
    <div class="form-reservas">
        <h1>Reservar Habitación</h1>
        <div class="habitacion-info">
            <h2><?php echo htmlspecialchars($habitacion['nombre']); ?></h2>
            <p>Costo: $<?php echo htmlspecialchars($habitacion['costo']); ?></p>
        </div>
        <form action="" method="POST">
            <div>
                <label for="fechainicio">Fecha de Inicio:</label>
                <input type="date" id="fechainicio" name="fechainicio" required>
            </div>
            <div>
                <label for="fechasalida">Fecha de Salida:</label>
                <input type="date" id="fechasalida" name="fechasalida" required>
            </div>
            <button type="submit" class="btn-reservar">Confirmar Reserva</button>
        </form>
    </div>
    </div>
</body>
</html>
