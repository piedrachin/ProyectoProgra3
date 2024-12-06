


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Habitaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/crud_habitaciones.css" rel="stylesheet">
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
    <h2 class="mb-4">Catálogo de Habitaciones</h2>
    <?php
    require_once "conexion_bd.php";

    $action = isset($_GET['action']) ? $_GET['action'] : 'list';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($action == "create") {
            $codigo = trim($_POST['codigo']);
            $nombre = trim($_POST['nombre']);
            $tipo = trim($_POST['tipo']);
            $mayordomo = trim($_POST['mayordomo']);
            $costo = trim($_POST['costo']);
            $foto = null;

            // Subida de imagen
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true); // Crear directorio si no existe
                }
                $target_file = $target_dir . basename($_FILES["foto"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $valid_extensions = ["jpg", "jpeg", "png", "gif"];
                if (in_array($imageFileType, $valid_extensions) && move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = $target_file;
                }
            }

            // Insertar nueva habitación
            $sql_insert = "INSERT INTO habitaciones (codigo, nombre, tipo, mayordomo, costo, foto) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt_insert = $conex->prepare($sql_insert)) {
                $stmt_insert->bind_param("ssssds", $codigo, $nombre, $tipo, $mayordomo, $costo, $foto);
                $stmt_insert->execute();
                $stmt_insert->close();
                header("Location: ?action=list");
                exit();
            }
        } elseif ($action == "update") {
            $codigo = trim($_POST['codigo']);
            $nombre = trim($_POST['nombre']);
            $tipo = trim($_POST['tipo']);
            $mayordomo = trim($_POST['mayordomo']);
            $costo = trim($_POST['costo']);
            $foto = $_POST['foto_actual'];

            // Subida de nueva imagen (si se proporciona)
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["foto"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $valid_extensions = ["jpg", "jpeg", "png", "gif"];
                if (in_array($imageFileType, $valid_extensions) && move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = $target_file;
                }
            }

            // Actualizar habitación
            $sql_update = "UPDATE habitaciones SET nombre = ?, tipo = ?, mayordomo = ?, costo = ?, foto = ? WHERE codigo = ?";
            if ($stmt_update = $conex->prepare($sql_update)) {
                $stmt_update->bind_param("sssdss", $nombre, $tipo, $mayordomo, $costo, $foto, $codigo);
                $stmt_update->execute();
                $stmt_update->close();
                header("Location: ?action=list");
                exit();
            }
        } elseif ($action == "delete") {
            $codigo = trim($_POST['codigo']);
            // Eliminar habitación
            $sql_delete = "DELETE FROM habitaciones WHERE codigo = ?";
            if ($stmt_delete = $conex->prepare($sql_delete)) {
                $stmt_delete->bind_param("s", $codigo);
                $stmt_delete->execute();
                $stmt_delete->close();
                header("Location: ?action=list");
                exit();
            }
        }
    }

    if ($action == "list") {
        // Mostrar lista de habitaciones
        $result = $conex->query("SELECT * FROM habitaciones");
        echo "<a href='?action=create' class='btn btn-primary mb-3'>Agregar Habitación</a>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Código</th><th>Nombre</th><th>Tipo</th><th>Mayordomo</th><th>Costo</th><th>Foto</th><th>Acciones</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['codigo']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['tipo']}</td>";
            echo "<td>{$row['mayordomo']}</td>";
            echo "<td>\${$row['costo']}</td>";
            
            echo "<td>";
            if (!empty($row['foto'])) {
                echo "<img src='{$row['foto']}' alt='Foto' style='width: 100px;'>";
            } else {
                echo "No disponible";
            }
            echo "</td>";
            echo "<td>
                    <a href='?action=update&codigo={$row['codigo']}' class='btn btn-warning btn-sm'>Editar</a> 
                    <a href='?action=delete&codigo={$row['codigo']}' class='btn btn-danger btn-sm'>Eliminar</a>
                  </td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } elseif ($action == "create") {
        // Formulario de creación
        echo "<h3>Agregar Habitación</h3>";
        echo "<form method='post' action='?action=create' enctype='multipart/form-data'>";
        echo "<div class='mb-3'><label class='form-label'>Código:</label><input type='text' name='codigo' class='form-control' required></div>";
        echo "<div class='mb-3'><label class='form-label'>Nombre:</label><input type='text' name='nombre' class='form-control' required></div>";
        echo "<div class='mb-3'><label class='form-label'>Tipo:</label><input type='text' name='tipo' class='form-control' required></div>";
        echo "<div class='mb-3'><label class='form-label'>Mayordomo:</label><input type='text' name='mayordomo' class='form-control' required></div>";
        echo "<div class='mb-3'><label class='form-label'>Costo:</label><input type='number' step='0.01' name='costo' class='form-control' required></div>";
        echo "<div class='mb-3'><label class='form-label'>Foto:</label><input type='file' name='foto' class='form-control'></div>";
        echo "<button type='submit' class='btn btn-success'>Guardar</button> ";
        echo "<a href='?action=list' class='btn btn-secondary'>Cancelar</a>";
        echo "</form>";
    } elseif ($action == "delete") {
        // Confirmar eliminación
        $codigo = $_GET['codigo'];
        echo "<h3>Eliminar Habitación</h3>";
        echo "<form method='post' action='?action=delete'>";
        echo "<input type='hidden' name='codigo' value='$codigo'>";
        echo "<p>¿Estás seguro de que deseas eliminar la habitación con el código <strong>$codigo</strong>?</p>";
        echo "<button type='submit' class='btn btn-danger'>Eliminar</button> ";
        echo "<a href='?action=list' class='btn btn-secondary'>Cancelar</a>";
        echo "</form>";
    } elseif ($action == "update") {
        // Formulario de edición
        $codigo = $_GET['codigo'];
        $sql = "SELECT * FROM habitaciones WHERE codigo = ?";
        if ($stmt = $conex->prepare($sql)) {
            $stmt->bind_param("s", $codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            echo "<h3>Editar Habitación</h3>";
            echo "<form method='post' action='?action=update' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='codigo' value='{$row['codigo']}'>";
            echo "<div class='mb-3'><label class='form-label'>Nombre:</label><input type='text' name='nombre' class='form-control' value='{$row['nombre']}' required></div>";
            echo "<div class='mb-3'><label class='form-label'>Tipo:</label><input type='text' name='tipo' class='form-control' value='{$row['tipo']}' required></div>";
            echo "<div class='mb-3'><label class='form-label'>Mayordomo:</label><input type='text' name='mayordomo' class='form-control' value='{$row['mayordomo']}' required></div>";
            echo "<div class='mb-3'><label class='form-label'>Costo:</label><input type='number' step='0.01' name='costo' class='form-control' value='{$row['costo']}' required></div>";
            echo "<div class='mb-3'><label class='form-label'>Foto Actual:</label>";
           

            if (!empty($row['foto'])) {
                echo "<img src='{$row['foto']}' alt='Foto' style='width: 100px;'><br>";
            } else {
                echo "No disponible<br>";
            }
            echo "<label class='form-label'>Nueva Foto:</label><input type='file' name='foto' class='form-control'></div>";
            echo "<input type='hidden' name='foto_actual' value='{$row['foto']}'>";
            echo "<button type='submit' class='btn btn-success'>Actualizar</button> ";
            echo "<a href='?action=list' class='btn btn-secondary'>Cancelar</a>";
            echo "</form>";
        }
    }
    ?>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
