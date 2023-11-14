<?php
session_start();
include '../DB/dbconnect.php';

// Comprobar si el usuario es administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensaje'] = "No tienes permisos para realizar esta acción.";
    header('Location: ../PHP/blog.php');
    exit;
}

// Comprobar si se recibió el ID del usuario
if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    // Preparar la consulta para eliminar el usuario
    $query = $mysqli->prepare("DELETE FROM Users WHERE Code = ?");
    $query->bind_param("i", $userId);

    // Intentar ejecutar la consulta
    if ($query->execute()) {
        $_SESSION['mensaje'] = "Usuario eliminado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el usuario: " . $mysqli->error;
    }
} else {
    $_SESSION['mensaje'] = "No se proporcionó el ID del usuario.";
}

$mysqli->close();
header('Location: ../PHP/AdminPanel.php');
exit;
?>
