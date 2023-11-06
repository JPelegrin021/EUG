<?php
session_start();
// Conexión a la base de datos (ajusta tus credenciales)
$mysqli = new mysqli("localhost", "usuario", "contraseña", "basededatos");

if ($mysqli->connect_error) {
    die("Error de conexión a la base de datos: " . $mysqli->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT id, username, password, role_id FROM users WHERE username='$username'";

$result = $mysqli->query($query);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role_id'] = $row['role_id'];
        header("Location: dashboard.php"); // Redirige al panel de usuario
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Nombre de usuario incorrecto.";
}

$mysqli->close();
?>
