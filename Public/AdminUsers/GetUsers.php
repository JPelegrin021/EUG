<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getUsers($mysqli) {
    $users = [];

    $result = $mysqli->query("SELECT Code, UserName, Admin FROM Users ORDER BY UserName ASC");
    
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    return $users;
}
?>