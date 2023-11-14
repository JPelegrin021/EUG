<?php
session_start();
include("../DB/dbconnect.php");

if (isset($_POST['postCode'], $_POST['userCode'], $_POST['comment'])) {
    $postCode = $_POST['postCode'];
    $userCode = $_POST['userCode'];
    $comment = $_POST['comment'];

    // Preparar y ejecutar la consulta para insertar el comentario
    $stmt = $mysqli->prepare("INSERT INTO Comments (User, Post, Comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $userCode, $postCode, $comment);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Comentario añadido con éxito
        $_SESSION['mensaje'] = "Comentario añadido correctamente.";
    } else {
        // Error al añadir el comentario
        $_SESSION['mensaje'] = "Error al añadir el comentario.";
    }

    $stmt->close();
    $mysqli->close();
}

// Redirigir de vuelta a la página de blog
header("Location: ../PHP/blog.php");
exit;
?>
