<?php
session_start();
include '../DB/dbconnect.php';;

// Comprobar si el usuario es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción.";
    header('Location: ../PHP/blog.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];


    $query = $mysqli->prepare("DELETE FROM Likes WHERE Post = ?");
    $query->bind_param("i", $post_id);
    $query->execute();
    // Primero, eliminar los comentarios asociados al post
    $query = $mysqli->prepare("DELETE FROM Comments WHERE Post = ?");
    $query->bind_param("i", $post_id);
    $query->execute();

    // Luego, eliminar el post
    $query = $mysqli->prepare("DELETE FROM Posts WHERE Code = ?");
    $query->bind_param("i", $post_id);
    if ($query->execute()) {
        $_SESSION['mensaje'] = "Post eliminado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el post: " . $mysqli->error;
    }

    $mysqli->close();
} else {
    $_SESSION['mensaje'] = "No se proporcionó un ID de post válido.";
}


header('Location: ../PHP/AdminPanel.php');
exit;
?>
