<?php include_once("initAdmin.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio</title>
    <link rel="stylesheet" href="css/paginaprincipal.css"/>
    <link rel="stylesheet" href="css/mapa.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>

<body>
<header>
    <?php
    session_start();
    $usuarioAutenticado = isset($_SESSION['usuario']);
    ?>
    <nav class="navbar">
        <ul class="menu">
            <li><a href="paginaprincipal.php">Inicio</a></li>
            <li><a href="servicios.php">Habitaciones</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="acerca.php">Acerca</a></li>
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
               


    <!-- Información General -->
    <section class="info-hotel">
        <h1>Bienvenido al Hotel Bitsú</h1>
        <p>
            Ubicado en el corazón de la ciudad, nuestro hotel ofrece una experiencia
            única de comodidad y lujo.
        </p>
        <ul>
            <li>Habitaciones modernas y bien equipadas.</li>
            <li>Wi-Fi gratuito en todo el hotel.</li>
            <li>Restaurante gourmet con vista panorámica.</li>
            <li>Ubicación cerca de los principales atractivos turísticos.</li>
        </ul>
    </section>

               
                  <!-- Banner con Slider -->

    <div class="banner">
        <div class="slider">
            <img src="Image/habitacion1.jpg" alt="Habitación 1" />
            <img src="Image/habitacion2.jpg" alt="Habitación 2" />
            <img src="Image/h1.jpg" alt="Habitación 3" />
            <img src="Image/h2.jpg" alt="Habitación 4" />
            <img src="Image/espacio1.jpg" alt="Espacios Comunes" />
            <img src="Image/espacio2.jpg" alt="Espacios Comunes" />
            <img src="Image/espacio3.jpg" alt="Espacios Comunes" />
        </div>
    </div>
             
    <h1>Servicios del hotel</h1>
    <div class="servicios-hotel">
    
   
        <div class="card">
       
            <figure>
                <img src="Image/playa.jpg" >
            </figure>
            <div class="contenido">
                <h3>Mayordomo</h3>
                <p>Lo que necesites, te lo tr</p>
            </div>
        </div>

        <div class="card">
       
       <figure>
           <img src="Image/playa.jpg" >
       </figure>
       <div class="contenido">
           <h3>WI-FI</h3>
           <p>Wifi ilimitado para tu comodidad</p>
       </div>
   </div>
   <div class="card">
       
       <figure>
           <img src="Image/playa.jpg" >
       </figure>
       <div class="contenido">
           <h3>Piscina</h3>
           <p>Date un gran chapuzon</p>
       </div>
   </div>

   <div class="card">
       
       <figure>
           <img src="Image/playa.jpg" >
       </figure>
       <div class="contenido">
           <h3>Restaurante</h3>
           <p>Come una deliciosa comida, te la mereces</p>
       </div>
   </div>
  
    </div>
        
             
      <div class="ubicacion-hotel">  
    <div class="contenedor-centrado">

<h1>Ubicación del Hotel</h1>
<div id="map"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="Script/mapa.js"></script>

</div> 
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

        
    </div>
</body>

</html>
