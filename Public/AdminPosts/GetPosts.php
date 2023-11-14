<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getPosts($mysqli) {
    $posts = [];

    $result = $mysqli->query("
        SELECT Posts.*, Users.UserName
        FROM Posts
        JOIN Users ON Posts.User = Users.Code
        ORDER BY Posts.Date DESC
    ");
    
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    return $posts;
}

?>