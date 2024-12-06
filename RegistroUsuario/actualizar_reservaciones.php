<?php
require_once "conexion_bd.php";
session_start();

// Verificar si el usuario está autenticado y es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== 'admin') {
    echo "<p>No tienes permiso para acceder a esta página.</p>";
    exit();
}

// Procesar actualización de estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_reserva'], $_POST['estado'])) {
    $id_reserva = $_POST['id_reserva']; // ID de la reserva enviada por el formulario
    $nuevo_estado = $_POST['estado'];   // Nuevo estado enviado por el formulario

    // Validar el nuevo estado
    if (in_array($nuevo_estado, ['pendiente', 'realizada'])) {
        $sql_update = "UPDATE reservaciones SET estado = ? WHERE id_reserva = ?";
        $stmt_update = $conex->prepare($sql_update);
        $stmt_update->bind_param("si", $nuevo_estado, $id_reserva);

        // Ejecutar la consulta y verificar el resultado
        if ($stmt_update->execute()) {
            echo "<p>El estado de la reserva ID $id_reserva se actualizó correctamente.</p>";
        } else {
            echo "<p>Error al actualizar el estado de la reserva.</p>";
        }

        $stmt_update->close(); // Cerrar el statement
    } else {
        echo "<p>Estado inválido.</p>";
    }
}

// Consultar todas las reservaciones
$sql = "SELECT id_reserva, codigo_habitacion, fechainicio, fechasalida, estado, fechareserva 
        FROM reservaciones";
$result = $conex->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Reservaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/actualizar_reservas.css" rel="stylesheet">
</head>
<body>
<header>
    <?php
   
    $usuarioAutenticado = isset($_SESSION['usuario']);
    ?>
    <nav class="navbar">
        <ul class="menu">
            <li><a href="paginaprincipal.php">Regresar</a></li>
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
            <?php endif; ?>
        </ul>
    </nav>
</header>
    <div class="container my-5">
        <h2 class="text-center mb-4">Actualizar Reservaciones</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID Reserva</th>
                            <th>Código Habitación</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Salida</th>
                            <th>Estado</th>
                            <th>Fecha Reserva</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="text-center align-middle">
                                <td><?php echo htmlspecialchars($row['id_reserva']); ?></td>
                                <td><?php echo htmlspecialchars($row['codigo_habitacion']); ?></td>
                                <td><?php echo htmlspecialchars($row['fechainicio']); ?></td>
                                <td><?php echo htmlspecialchars($row['fechasalida']); ?></td>
                                <td>
                                    <?php echo ($row['estado'] === 'realizada') ? 
                                        "<span class='badge bg-success'>Facturada</span>" : 
                                        "<span class='badge bg-warning text-dark'>Pendiente</span>"; ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['fechareserva']); ?></td>
                                <td>
                                    <!-- Formulario para actualizar el estado de una sola reserva -->
                                    <form action="" method="POST" class="d-inline">
                                        <input type="hidden" name="id_reserva" value="<?php echo htmlspecialchars($row['id_reserva']); ?>">
                                        <select name="estado" class="form-select form-select-sm d-inline w-auto">
                                            <option value="pendiente" <?php echo ($row['estado'] === 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                            <option value="realizada" <?php echo ($row['estado'] === 'realizada') ? 'selected' : ''; ?>>Realizada</option>
                                        </select>
                                        <button class="btn btn-primary btn-sm" type="submit">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                No hay reservaciones registradas.
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conex->close();
?>
