<?php
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta

include 'GetPosts.php'; // Asegúrate de que esta ruta sea correcta

function getPostDetails($mysqli, $postCode) {
    $query = $mysqli->prepare("SELECT Code, Title, Resume FROM Posts WHERE Code = ?");
    $query->bind_param("i", $postCode);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

if (isset($_GET['postCode'])) {
    $postCode = $_GET['postCode'];
    $postDetails = getPostDetails($mysqli, $postCode);

    header('Content-Type: application/json');
    if ($postDetails) {
        echo json_encode($postDetails);
    } else {
        echo json_encode(['error' => 'Post no encontrado']);
    }
}

?>