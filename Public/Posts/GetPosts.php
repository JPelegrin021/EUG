<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getPosts($mysqli, $search = null) {
    $posts = [];
    $sql = "
        SELECT Posts.*, Posts.Code, Posts.Title, Posts.Resume, Posts.Content, Posts.Image, Users.UserName
        FROM Posts
        JOIN Users ON Posts.User = Users.Code
    ";

    if ($search) {
        $searchTerm = '%' . $mysqli->real_escape_string($search) . '%';
        $sql .= "WHERE Posts.Title LIKE ? OR Posts.Resume LIKE ? OR Users.UserName LIKE ?";
    }

    $sql .= " ORDER BY Posts.Date DESC";
    $query = $mysqli->prepare($sql);

    if ($search) {
        $query->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
    }

    $query->execute();
    $result = $query->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    return $posts;
}


?>