<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$dbname = 'todoApp';

$con = new mysqli($host, $user, $pass, $dbname);

if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}
?>