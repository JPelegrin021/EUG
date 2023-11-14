<?php
session_start();
include '../DB/dbconnect.php';

// Asegúrate de que solo los administradores pueden cambiar este estado
if (!isset($_SESSION['usuario']) || $_SESSION['admin'] != 1) {
    echo "No tienes permiso para realizar esta acción.";
    exit;
}

$userId = $_POST['userId'];
$isAdmin = $_POST['isAdmin'];

// Validar que isAdmin sea 0 o 1
if (!in_array($isAdmin, ['0', '1'], true)) {
    echo "Valor inválido.";
    exit;
}

// Actualizar el estado de administrador en la base de datos
$query = $mysqli->prepare("UPDATE Users SET Admin = ? WHERE Code = ?");
$query->bind_param("ii", $isAdmin, $userId);
if ($query->execute()) {
    echo "Estado de administrador actualizado.";
} else {
    echo "Error al actualizar el estado: " . $mysqli->error;
}

$mysqli->close();
?>
