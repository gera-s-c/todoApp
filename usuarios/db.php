<?php

// Datos de conexión a la base de datos de Laragon
$servername = "localhost"; // O 127.0.0.1
$username = "root";        // Usuario de la base de datos en Laragon
$password = "";            // Contraseña (vacía por defecto en Laragon)
$dbname = "todoApp"; // ¡El nombre de tu base de datos en Laragon!

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// echo "Conexión exitosa a la base de datos!"; // Solo para probar la conexión
?>