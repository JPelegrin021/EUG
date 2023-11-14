<?php
include '../DB/dbconnect.php';

session_start();

if (isset($_POST['comment_id'])) {
    $commentId = $_POST['comment_id'];

    $query = $mysqli->prepare("DELETE FROM Comments WHERE Code = ?");
    if (!$query) {
        $_SESSION['mensaje'] = 'Error en la preparación de la consulta: ' . $mysqli->error;
        header('Location: ../PHP/AdminPanel.php');
        exit;
    }

    $query->bind_param("i", $commentId);
    if (!$query->execute()) {
        $_SESSION['mensaje'] = 'Error al ejecutar la consulta: ' . $mysqli->error;
    } else {
        $_SESSION['mensaje'] = "Comentario eliminado con éxito.";
    }

    $mysqli->close();
    header('Location: ../PHP/AdminPanel.php');
} else {
    $_SESSION['mensaje'] = "ID de comentario no proporcionado.";
    header('Location: ../PHP/AdminPanel.php');
}
?>
