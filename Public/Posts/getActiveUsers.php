<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

function getActiveUsers($mysqli) {
    $tenMinutesAgo = date('Y-m-d H:i:s', time() - 600); // Hace 10 minutos
    $query = $mysqli->prepare("SELECT UserName FROM Users WHERE last_activity > ?");
    $query->bind_param("s", $tenMinutesAgo);
    $query->execute();
    $result = $query->get_result();

    $activeUsers = [];
    while ($user = $result->fetch_assoc()) {
        $activeUsers[] = $user['UserName'];
    }

    return $activeUsers;
}

?>
