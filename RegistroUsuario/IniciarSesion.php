<?php
session_start(); // Inicia la sesión
include("conexion_bd.php"); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    // Consulta para obtener los datos del usuario
    $consulta = "SELECT id, usuario1, contrasena1, tipo_usuario FROM datos WHERE usuario1 = ?";
    $stmt = $conex->prepare($consulta);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuarioData = $resultado->fetch_assoc();

    if ($usuarioData && password_verify($contrasena, $usuarioData['contrasena1'])) {
        // Credenciales correctas: guardar datos en la sesión
        $_SESSION['usuario_id'] = $usuarioData['id'];
        $_SESSION['usuario'] = $usuarioData['usuario1'];
        $_SESSION['tipo_usuario'] = $usuarioData['tipo_usuario'];

        // Redirigir a la página principal
        header("Location: paginaprincipal.php");
        exit();
    } else {
        // Credenciales incorrectas
        $mensaje = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conex->close();
}


