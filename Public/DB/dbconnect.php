<?php
$host = 'servergj.ddns.net';
$user = 'Remoto';
$password = '54er.2lYP9oK/';
$database = 'Blog';
$port = 3306;

$mysqli = new mysqli($host, $user, $password, $database, $port);

if ($mysqli->connect_error) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}
?>
