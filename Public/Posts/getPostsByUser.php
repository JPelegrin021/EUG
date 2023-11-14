<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getPostsByUser($mysqli, $userId) {
    // Modifica la consulta para incluir un JOIN con la tabla Users
    $stmt = $mysqli->prepare("
        SELECT Posts.*, Users.UserName 
        FROM Posts 
        JOIN Users ON Posts.User = Users.Code 
        WHERE Posts.User = ?
    ");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $posts = [];
    while ($post = $result->fetch_assoc()) {
        $posts[] = $post;
    }

    $stmt->close();
    return $posts;
}

?>
