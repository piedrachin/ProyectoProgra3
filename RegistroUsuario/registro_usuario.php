<?php
include("conexion_bd.php");

if(isset($_POST["registro"])) {
    if(
        strlen($_POST['identificacion']) >= 1 &&
        strlen($_POST['nombre']) >= 1 &&
        strlen($_POST['apellidoUno']) >= 1 &&
        strlen($_POST['apellidoDos']) >= 1 &&
        strlen($_POST['usuario']) >= 1 &&
        strlen($_POST['contrasena']) >= 1 &&
        strlen($_POST['telefono']) >= 1 &&
        strlen($_POST['correo']) >= 1
    ) {
        $identificacion = trim($_POST['identificacion']);
        $nombre = trim($_POST['nombre']);
        $apellidoUno = trim($_POST['apellidoUno']);
        $apellidoDos = trim($_POST['apellidoDos']);
        $usuario = trim($_POST['usuario']);
        $contrasena = trim($_POST['contrasena']);
        $telefono = trim($_POST['telefono']);
        $correo = trim($_POST['correo']);
        $fecha = date("d/m/y");

        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Usando una consulta preparada para evitar SQL Injection
        $consulta = "INSERT INTO datos(id,nombre,apellido1,apellido2,usuario1,contrasena1,telefono,correo,fecha)
                     VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conex->prepare($consulta);
        $stmt->bind_param("sssssssss", $identificacion, $nombre, $apellidoUno, $apellidoDos, $usuario, $contrasenaHash, $telefono, $correo, $fecha);

        if ($stmt->execute()) {
            // Redirigir a login.php si el registro fue exitoso
            header("Location: login.php");
            exit();
        } else {
            echo "<h3 class='error'>Ocurrió un error al registrar los datos</h3>";
        }
    }
}
?>

