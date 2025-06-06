<?php

require 'db.php';

//consulta registro de base de datos
$sql = "SELECT * FROM CRUD ORDER BY id DESC";
$result = $con->query($sql);


// Datos de conexión a la base de datos de Laragon
$servername = "localhost"; // O 127.0.0.1
$username = "root";        // Usuario de la base de datos en Laragon
$password = "";            // Contraseña (vacía por defecto en Laragon)
$dbname = "todoApp"; // ¡El nombre de tu base de datos en Laragon!

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="build/css/app.css">
        <link rel="stylesheet" href="src/scss/app.scss">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="https://fontawesome.com/icons/trash?f=classic&s=solid">
        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <title>Todo Applet</title>
        
    </head>
    <body>

        <link rel="stylesheet" href="/src/css/app.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <title>Todo Applet</title>
    </head>
    <body>
        <div class="container">
            <h1>Bienvenido a mi Aplicación</h1>
            <p>Esta es la página principal de tu proyecto.</p>
            <p>Para usar la aplicación, por favor:</p>
            <p><a href="/usuarios/inicioSesion.php">Iniciar Sesión</a></p>
            <p>¿No tienes una cuenta? <a href="/usuarios/registro.php">Registrarse</a></p>
        </div>
        <!--Encabesado-->
        <header class="header">
            <div class="contenedor contenido-header">
                <h1>A Todo App</h1>

                <nav class="navegacion">
                    <a href="/nosotros/nosotros.html">Nosotros</a>
                    <a href="/contactos/contactos.html">Contacto</a>
                    <a href="#">Mi usuario</a>


                <nav class="navegacion">
                    <a href="/nosotros/nosotros.html">Nosotros</a>
                    <a href="/contactos/contactos.html">Contacto</a>
                    <a href="/mi usuario/miUsuario.html">Mi usuario</a>
                </nav>
            </div>
        </header>
        <div class="contenido-vertical">   
            <nav class="navegacion-vertical"> 
                <a href="/comunidad/comonidad.html">Comunidad</a>
                <a href="#">Noticias</a>
                <a href="/eventos/eventos.html">Eventos</a>
            </nav>

            <main class="main-content">
                <div class="contenedo-nuevo">
                    <a href="crud/create.php" class="button nuevo">Nuevo</a>
                </div>
                <!-- Formulario de búsqueda -->
            <form method="GET" action="" style="margin-bottom: 20px;">
                <input type="text" name="q" placeholder="Buscar tareas..."  ?>
                <button type="submit">Buscar</button>
            </form>

                <div class="cuadro-tabla">
                    <table class="cuadro-crud">
                        <thead>
                            <tr>
                                <th>Nro</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Tarea</th>
                                <th>Descripcion</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['nombre'] ?></td>
                                        <td><?= $row['apellido'] ?></td>
                                        <td><?= isset($row['title']) ? htmlspecialchars($row['title']) : '' ?></td>
                                        <td><?= isset($row['descripcion']) ? htmlspecialchars($row['descripcion']) : '' ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td>
                                            <a href="crud/ver.php?id=<?= $row['id'] ?>" class="fa-solid fa-eye"></a> 
                                            <a href="crud/update.php?id=<?= $row['id'] ?>" class="button fa-solid fa-file"></a>
                                            <a href="crud/delete.php?id=<?= $row['id'] ?>" class="button delete fa-solid fa-trash" onclick="return confirm('¿Estas seguro de eliminar esta tarea?');"></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5">No hay tareas registradas.</td></tr>
                            <?php endif; ?>    
                        </tbody>
                    </table>
                </div>    
                <section class="informacion-general">
                    <img src="src/img/paisaje.jpg" alt="Descripcion de la imagen">


            <main>
                <p class="destacado">Lo mas destacado de la semna </p>
                <section class="informacion-general">
                    <img src="/src/img/paisaje.jpg" alt="Descripcion de la imagen">
                    <p class="text">Lorem ipsum dolor sit amet consectetur 
                        adipisicing elit. Repellat vero dolores 
                        inventore expedita dolorem at minus quisquam 
                        asperiores. Similique, temporibus distinctio! 
                        Possimus dolor, ratione labore tenetur reprehenderit 
                        dicta dolorum repudiandae?
                    </p>
                </section>
            </main>
        </div>
        <footer>
            <h1>
                Redes
            </h1>
        </footer>
    </body>
</html>