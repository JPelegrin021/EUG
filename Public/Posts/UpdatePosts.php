<?php
session_start();
include '../DB/dbconnect.php';

if (!isset($_SESSION['usuario'])) {
    // Redirigir al usuario si no ha iniciado sesión
    header('Location: ../PHP/blog.php');
    exit;
}

if (isset($_POST['postId'], $_POST['title'], $_POST['summary'])) {
    $postId = $_POST['postId'];
    $title = $_POST['title'];
    $summary = $_POST['summary'];

    // Aquí implementas la lógica para actualizar el post en la base de datos
    // Por ejemplo:
    $query = $mysqli->prepare("UPDATE Posts SET Title = ?, Resume = ? WHERE Code = ?");
    $query->bind_param("ssi", $title, $summary, $postId);
    $query->execute();

    if ($query->affected_rows > 0) {
        // Redireccionar con mensaje de éxito
        $_SESSION['mensaje'] = "Post actualizado correctamente.";
    } else {
        // Redireccionar con mensaje de error
        $_SESSION['mensaje'] = "Error al actualizar el post.";
    }
}

header('Location: ../PHP/blog.php');
exit;
?>
