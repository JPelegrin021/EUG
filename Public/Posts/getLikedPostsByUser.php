<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getLikedPostsByUser($mysqli, $userId) {
    $likedPosts = [];

    // Consulta para obtener los posts que el usuario ha dado like
    $sql = "
        SELECT Posts.*, Users.UserName
        FROM Likes
        JOIN Posts ON Likes.Post = Posts.Code
        JOIN Users ON Posts.User = Users.Code
        WHERE Likes.User = ?
        ORDER BY Posts.Date DESC
    ";

    $query = $mysqli->prepare($sql);
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();

    while ($row = $result->fetch_assoc()) {
        $likedPosts[] = $row;
    }
    return $likedPosts;
}


?>