<?php
// Conexión a la base de datos (ajusta tus credenciales)
$mysqli = new mysqli("localhost", "usuario", "contraseña", "basededatos");

if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$query = "INSERT INTO users (username, password, email, role_id) VALUES ('$username', '$password', '$email', 1)";

if ($mysqli->query($query) === TRUE) {
    echo "Registro exitoso.";
} else {
    echo "Error al registrar: " . $mysqli->error;
}

$mysqli->close();
?>
