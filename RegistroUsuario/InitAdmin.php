<?php
include_once("conexion_bd.php"); // Incluye la conexión a la base de datos

// Consulta para verificar si el usuario administrador ya existe
$query = "SELECT * FROM datos WHERE usuario1 = 'admin'";
$result = $conex->query($query);

if ($result->num_rows === 0) {
    // Si no existe el usuario administrador, lo creamos
    $hashed_password = password_hash('admin123*+', PASSWORD_BCRYPT); // Contraseña encriptada

    // Crear el usuario administrador con los campos requeridos
    $insert_query = "INSERT INTO datos (id, nombre, apellido1, apellido2, usuario1, contrasena1, telefono, correo, tipo_usuario) 
                     VALUES ('123456789', 'Administrador', 'AdminApellido1', 'AdminApellido2', 'admin', '$hashed_password', '1234567890', 'admin@hotelbitsu.com', 'admin')";

    if ($conex->query($insert_query)) {
        echo "Usuario administrador creado exitosamente.";
    } else {
        echo "Error al crear el administrador: " . $conex->error;
    }
}

// Cierra la conexión a la base de datos
$conex->close();
?>

