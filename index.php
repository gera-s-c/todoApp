<?php

session_start(); // Siempre inicia la sesión al principio de la página


if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión
    header("Location: /usuarios/inicioSesion.php"); // Asegúrate que esta ruta sea correcta
    exit(); // Es crucial terminar la ejecución del script después de la redirección
};

require 'db.php';

//consulta registro de base de datos
$sql = "SELECT * FROM CRUD ORDER BY id DESC";
$result = $con->query($sql);





$user_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Usuario';
$user_email = isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'No disponible';

// Datos de conexión a la base de datos de Laragon
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "todoApp";       

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Manejo de error de conexión (opcional, pero buena práctica)
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="es">
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
        <header class="header">
            <div class="contenedor contenido-header">
                <h1>A Todo App</h1>
                <nav class="navegacion">
                    <a href="/mi usuario/miUsuario.html">Mi usuario</a>
                </nav>
            </div>
        </header>
        <div class="contenido-vertical">  
            <nav class="navegacion-vertical"> 
                <a href="vistas/comunidad/comonidad.html">Comunidad</a>
                <a href="vistas/noticias/noticias.html">Noticias</a>
                <a href="vistas/eventos/eventos.html">Eventos</a>
                <a href="vistas/nosotros/nosotros.html">Nosotros</a>
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
                    
            <main>
                <p class="destacado">Lo mas destacado de la semana </p>
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
                <p class="destacado">Comunidad de la semana</p>
                <section class="informacion-general">
                    <img src="/src/img/comunidad.jpg" alt="Descripcion de la imagen">
                    <p class="text">Lorem ipsum dolor sit amet consectetur 
                        adipisicing elit. Repellat vero dolores 
                        inventore expedita dolorem at minus quisquam 
                        asperiores. Similique, temporibus distinctio! 
                        Possimus dolor, ratione labore tenetur reprehenderit 
                        dicta dolorum repudiandae?
                    </p>
                </section>
                </section>
                <p class="destacado">Usuario mas destacado</p>
                <section class="informacion-general">
                    <img src="/src/img/usuario.png" alt="Descripcion de la imagen">
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
            <h1>Redes</h1>
        </footer>
    </body>
</html>
<?php

if (isset($conn) && $conn->ping()) { // Comprueba si la conexión existe y es válida
    $conn->close();
}
?>