<?php
// Iniciar la sesión
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

// Verificar si el formulario fue enviado
if (isset($_POST['actualizar'])) {
    // Obtener los datos del formulario
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $apellidoUno = $_POST['apellidoUno'];
    $apellidoDos = $_POST['apellidoDos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Si la contraseña está vacía, no la actualizamos
    if (empty($contrasena)) {
        $sql = "UPDATE datos SET nombre = ?, apellido1 = ?, apellido2 = ?, telefono = ?, correo = ? WHERE usuario1 = ?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $apellidoUno, $apellidoDos, $telefono, $correo, $usuarioSesion);
    } else {
        // Si la contraseña no está vacía, la actualizamos
        $sql = "UPDATE datos SET nombre = ?, apellido1 = ?, apellido2 = ?, telefono = ?, correo = ?, contrasena = ? WHERE usuario1 = ?";
        $stmt = $conex->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $apellidoUno, $apellidoDos, $telefono, $correo, $contrasena, $usuarioSesion);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si la actualización fue exitosa, redirigir al perfil
        header("Location: paginaprincipal.php");
        exit();
    } else {
        echo "Error al actualizar los datos.";
    }
}
?>

