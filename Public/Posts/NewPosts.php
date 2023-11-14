<?php
session_start();
include '../DB/dbconnect.php'; // Asegúrate de que esta ruta sea correcta
include 'updateLastActivity.php'; 

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensaje'] = "Por favor, inicie sesión para publicar un post.";
    header('Location: ../Login/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['usuario_id']; // El ID del usuario debe establecerse durante el inicio de sesión

    // Procesar la carga de archivos
    $directorio = $_SERVER['DOCUMENT_ROOT'] . '/EUG/Public/Posts/Images/'; // Ajusta la ruta al directorio de imágenes
    $archivo = $directorio . basename($_FILES["imagen"]["name"]);
    $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
    $validarImagen = getimagesize($_FILES["imagen"]["tmp_name"]);

    if ($validarImagen !== false) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo)) {
            $nombreImagen = basename($_FILES["imagen"]["name"]); // Aquí solo necesitas el nombre del archivo, no la ruta completa
        } else {
            $_SESSION['mensaje'] = "Hubo un error subiendo el archivo.";
            header('Location: ../PHP/posts.php');
            exit;
        }
    } else {
        $_SESSION['mensaje'] = "El archivo no es una imagen válida.";
        updateLastActivity($mysqli, $user['Code']);
        header('Location: ../PHP/posts.php');
        exit;
    }

    // Insertar datos en la base de datos
    $query = $mysqli->prepare("INSERT INTO Posts (User, Title, Resume, Content, Image) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("issss", $usuario_id, $titulo, $resumen, $contenido, $nombreImagen);
    if ($query->execute()) {
        $_SESSION['mensaje'] = "Post publicado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al publicar el post: " . $mysqli->error;
    }

    $mysqli->close();
    header('Location: ../PHP/blog.php'); // Asegúrate de que esta sea la ruta correcta para volver al blog
    exit;
} else {
    // Si no se enviaron datos POST, redireccionar a la página de creación de posts
    header('Location: ../PHP/posts.php');
    exit;
}
?>
