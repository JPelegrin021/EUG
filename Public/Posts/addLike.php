<?php
session_start();
include '../DB/dbconnect.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "Usuario no autenticado";
    exit;
}

$postCode = $_POST['postCode'] ?? null;
$userId = $_SESSION['usuario_id'];

$checkQuery = $mysqli->prepare("SELECT * FROM Likes WHERE User = ? AND Post = ?");
$checkQuery->bind_param("ii", $userId, $postCode);
$checkQuery->execute();
$result = $checkQuery->get_result();

if ($result->num_rows == 0) {
    // No hay 'like', entonces insertar
    $insertQuery = $mysqli->prepare("INSERT INTO Likes (User, Post) VALUES (?, ?)");
    $insertQuery->bind_param("ii", $userId, $postCode);
    if ($insertQuery->execute()) {
        echo "Like agregado";
    } else {
        echo "Error al agregar like";
    }
} else {
    // Ya existe 'like', entonces eliminar
    $deleteQuery = $mysqli->prepare("DELETE FROM Likes WHERE User = ? AND Post = ?");
    $deleteQuery->bind_param("ii", $userId, $postCode);
    if ($deleteQuery->execute()) {
        echo "Like eliminado";
    } else {
        echo "Error al eliminar like";
    }
}

$mysqli->close();
?>
