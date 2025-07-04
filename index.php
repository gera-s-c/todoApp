<?php
require 'db.php';

//consulta registro de base de datos
$sql = "SELECT * FROM CRUD ORDER BY id DESC";
$result = $conn->query($sql);
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
        <!--Encabesado-->
        <header class="header">
            <div class="contenedor contenido-header">
                <h1>A Todo App</h1>
                <nav class="navegacion">
                    <a href="/nosotros/nosotros.html">Nosotros</a>
                    <a href="/contactos/contactos.html">Contacto</a>
                    <a href="#">Mi usuario</a>
                </nav>
            </div>
        </header>
        <div class="contenido-vertical">   
            <nav class="navegacion-vertical"> 
                <a href="/comunidad/comonidad.html">Comunidad</a>
                <a href="#">Noticias</a>
                <a href="/eventos/eventos.html">Eventos</a>
            </nav>
            <main>
                <p class="destacado">Lo mas destacado de la semna </p>
                <div class="contenedo-nuevo">
                    <a href="crud/create.php" class="button nuevo">Nuevo</a>
                </div>
                <div class="cuadro-table">
                    <table class="cuadro-crud">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titulo</th>
                                <th>Fecha</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= htmlspecialchars($row['title']) ?></td>
                                        <td><?= $row['created_at'] ?></td>
                                        <td>
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