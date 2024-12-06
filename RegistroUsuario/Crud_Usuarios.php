<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/crud_usuario.css" rel="stylesheet">
</head>
<body>
    <header>
    <?php
    session_start();
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
<div class="container mt-5">
    <?php
    require_once "conexion_bd.php";

    $action = isset($_GET['action']) ? $_GET['action'] : 'list';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($action == "update") {
            $id = trim($_POST['id']);
            $nombre = trim($_POST['nombre']);
            $apellido1 = trim($_POST['apellido1']);
            $apellido2 = trim($_POST['apellido2']);
            $usuario = trim($_POST['usuario']);
            $correo = trim($_POST['correo']);
            $telefono = trim($_POST['telefono']);

            if (!empty($id) && !empty($nombre) && !empty($apellido1) && !empty($apellido2) && !empty($usuario) && !empty($correo) && !empty($telefono)) {
                $sql = "UPDATE datos SET nombre = ?, apellido1 = ?, apellido2 = ?, usuario1 = ?, correo = ?, telefono = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($conex, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssssss", $nombre, $apellido1, $apellido2, $usuario, $correo, $telefono, $id);
                    mysqli_stmt_execute($stmt);
                }
                mysqli_stmt_close($stmt);
            }
        }
    }

    if ($action == "list") {
        $sql = "SELECT * FROM datos";
        $result = mysqli_query($conex, $sql);
        echo "<h2 class='mb-4'>Usuarios Registrados</h2>";
        echo "<a href='?action=create' class='btn btn-primary mb-3'>Crear Usuario</a>";
        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-striped table-bordered'>";
            echo "<thead class='table-dark'><tr><th>ID</th><th>Nombre</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Usuario</th><th>Correo</th><th>Teléfono</th><th>Acciones</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['nombre']}</td>";
                echo "<td>{$row['apellido1']}</td>";
                echo "<td>{$row['apellido2']}</td>";
                echo "<td>{$row['usuario1']}</td>";
                echo "<td>{$row['correo']}</td>";
                echo "<td>{$row['telefono']}</td>";
                echo "<td>
                        <a href='?action=update&id={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                        <a href='?action=delete&id={$row['id']}' class='btn btn-danger btn-sm'>Eliminar</a>
                      </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<div class='alert alert-info'>No hay usuarios registrados.</div>";
        }
    } elseif ($action == "update") {
        if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
            $id = trim($_GET['id']);
            $sql = "SELECT * FROM datos WHERE id = ?";
            if ($stmt = mysqli_prepare($conex, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
                if (mysqli_stmt_execute($stmt)) {
                    $result = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($result)) {
                        echo "<h2 class='mb-4'>Editar Usuario</h2>";
                        echo "<form method='post' action='?action=update' class='row g-3'>";
                        echo "<div class='col-md-6'><label class='form-label'>ID:</label><input type='text' name='id' value='{$row['id']}' class='form-control' readonly></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Nombre:</label><input type='text' name='nombre' value='{$row['nombre']}' class='form-control'></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Primer Apellido:</label><input type='text' name='apellido1' value='{$row['apellido1']}' class='form-control'></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Segundo Apellido:</label><input type='text' name='apellido2' value='{$row['apellido2']}' class='form-control'></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Usuario:</label><input type='text' name='usuario' value='{$row['usuario1']}' class='form-control'></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Correo:</label><input type='email' name='correo' value='{$row['correo']}' class='form-control'></div>";
                        echo "<div class='col-md-6'><label class='form-label'>Teléfono:</label><input type='text' name='telefono' value='{$row['telefono']}' class='form-control'></div>";
                        echo "<div class='col-12'><button type='submit' class='btn btn-success'>Actualizar</button>";
                        echo " <a href='?action=list' class='btn btn-secondary'>Cancelar</a></div>";
                        echo "</form>";
                    } else {
                        echo "<div class='alert alert-danger'>Usuario no encontrado.</div>";
                    }
                }
            }
        }
    }
    ?>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

