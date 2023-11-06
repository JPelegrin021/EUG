<?php
$host = '62.174.185.134';
$user = 'Remoto';
$password = '54er.2lYP9oK/';
$database = 'Cloud';
$port = 3306;

// Conexión a la base de datos
$mysqli = new mysqli($host, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}

$titulo = $_POST['titulo'];
$resumen = $_POST['resumen'];
$contenido = $_POST['contenido'];

$query = "INSERT INTO posts (titulo, resumen, contenido) VALUES ('$titulo', '$resumen', '$contenido')";

if ($mysqli->query($query) === TRUE) {
    echo "Post creado exitosamente.";
} else {
    echo "Error al crear el post: " . $mysqli->error;
}

// Cierra la conexión a la base de datos
$mysqli->close();
?>
