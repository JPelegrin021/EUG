<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getPostsByUserC($mysqli, $username) {
    $stmt = $mysqli->prepare("SELECT Posts.*, Users.UserName FROM Posts JOIN Users ON Posts.User = Users.Code WHERE Users.UserName = ?");
    $stmt->bind_param("s", $username);
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
