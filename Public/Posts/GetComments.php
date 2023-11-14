<?php
include '../DB/dbconnect.php';

// Asegúrate de que se ha proporcionado un postCode
if (isset($_GET['postCode'])) {
    $postCode = $_GET['postCode'];

    // Preparar la consulta SQL
    $query = $mysqli->prepare("SELECT Comments.*, Users.UserName FROM Comments JOIN Users ON Comments.User = Users.Code WHERE Comments.Post = ?");
    if (!$query) {
        echo json_encode(['error' => 'Error en la preparación de la consulta: ' . $mysqli->error]);
        exit;
    }

    // Ejecutar la consulta
    $query->bind_param("i", $postCode);
    if (!$query->execute()) {
        echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $mysqli->error]);
        exit;
    }

    $result = $query->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        // Si tienes una columna Date, formatea la fecha aquí
        $row['Date'] = date_format(date_create($row['Date']), 'Y-m-d H:i:s');
        $comments[] = $row;
    }

    // Devolver los comentarios en formato JSON
    echo json_encode($comments);
} else {
    // Devuelve un error si no se proporcionó postCode
    echo json_encode(['error' => 'postCode no proporcionado']);
}
?>
