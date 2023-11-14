<?php
session_start();
include '../DB/dbconnect.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Encriptar contraseña
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Validar que el usuario no exista ya
$query = $mysqli->prepare("SELECT * FROM Users WHERE UserName = ?");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
    header('Location: ../PHP/blog.php');
    exit;
}

// Insertar el nuevo usuario con la contraseña encriptada
$query = $mysqli->prepare("INSERT INTO Users (UserName, Password, Admin) VALUES (?, ?, 0)");
$query->bind_param("ss", $username, $hashedPassword); // Usar contraseña encriptada
if ($query->execute()) {
    $_SESSION['mensaje'] = "Usuario registrado exitosamente.";
} else {
    $_SESSION['mensaje'] = "Error al registrar el usuario: " . $mysqli->error;
}

$mysqli->close();
header('Location: ../PHP/blog.php');
exit;
?>
