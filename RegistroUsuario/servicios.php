<?php
include_once "conexion_bd.php";
session_start();


// Consulta las habitaciones disponibles
$sql = "SELECT codigo, nombre, costo, mayordomo, tipo, foto FROM habitaciones";
$result = $conex->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="css/servicios.css">
   
</head>
<body>
<header>
<?php
  
    $usuarioAutenticado = isset($_SESSION['usuario']);
    ?>
 <nav class="navbar">
        <ul class="menu">
            <li><a href="paginaprincipal.php">Inicio</a></li>
            <li><a href="servicios.php">Habitaciones</a></li>
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
    <h1>Habitaciones Disponibles</h1>
    <div class="contenedor-centrado">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<img src="' . htmlspecialchars($row['foto']) . '" alt="' . htmlspecialchars($row['nombre']) . '">';
                echo '<h2>' . htmlspecialchars($row['nombre']) . '</h2>';
                echo '<p>Costo: $' . htmlspecialchars($row['costo']) . '</p>';
                echo '<p>Mayordomo encargado: ' . htmlspecialchars($row['mayordomo']) . '</p>';
                echo'<p>Tipo: ' . htmlspecialchars($row['tipo']) . '</p>';
                echo '<a href="reservar.php?codigo_habitacion=' . urlencode($row['codigo']) . '" class="btn-reservar">Reservar</a>';
                echo '</div>';

            
            }
        } else {
            echo '<div class="sin-habitaciones">No hay habitaciones disponibles.</div>';
        }

        $conex->close();
        ?>
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
