<?php
require_once "conexion_bd.php";
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Debes iniciar sesión para ver tus reservaciones. <a href='login.php'>Iniciar sesión</a></p>";
    exit();
}

// Obtener el ID del usuario autenticado
$usuario_id = $_SESSION['usuario_id'];

// Consultar las reservaciones del usuario
$sql = "SELECT id_reserva, codigo_habitacion, fechainicio, fechasalida, estado, fechareserva 
        FROM reservaciones 
        WHERE usuario_id = ?";
$stmt = $conex->prepare($sql);
$stmt->bind_param("s", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Reservaciones</title>
    <link rel="stylesheet" href="css/crud_reservas.css"> <!-- Ruta del CSS -->
</head>
<body>
    <div class="container">
        <h2>Historial de Reservaciones</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
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
                        <tr>
                            <td><?php echo htmlspecialchars($row['id_reserva']); ?></td>
                            <td><?php echo htmlspecialchars($row['codigo_habitacion']); ?></td>
                            <td><?php echo htmlspecialchars($row['fechainicio']); ?></td>
                            <td><?php echo htmlspecialchars($row['fechasalida']); ?></td>
                            <td><?php echo htmlspecialchars($row['estado']); ?></td>
                            <td><?php echo htmlspecialchars($row['fechareserva']); ?></td>
                            <td>
                                <?php if ($row['estado'] === 'pendiente'): ?>
                                    <form action="cancelar_reserva.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="id_reserva" value="<?php echo htmlspecialchars($row['id_reserva']); ?>">
                                        <button class="btn-danger" type="submit">Cancelar</button>
                                    </form>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No tienes reservaciones registradas.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conex->close();
?>
