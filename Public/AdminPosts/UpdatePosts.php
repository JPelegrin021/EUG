<?php
session_start();
include '../DB/dbconnect.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensaje'] = "Acceso denegado.";
    header('Location: ../PHP/blog.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y validar los datos del formulario
    $postId = $_POST['post_id'];
    $titulo = $_POST['titulo'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];
    $imagenActual = $_POST['imagen_actual']; // Este campo debería ser añadido al formulario

    // Comprobar si se ha subido una nueva imagen
    $nombreImagen = $imagenActual; // Por defecto, mantener la imagen actual
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Procesar la nueva imagen subida
        $directorio = $_SERVER['DOCUMENT_ROOT'] . '/EUG/Public/Posts/Images/';
        $archivo = $directorio . basename($_FILES["imagen"]["name"]);
        $tipoArchivo = strtolower(pathinfo($archivo, PATHINFO_EXTENSION));
        $validarImagen = getimagesize($_FILES["imagen"]["tmp_name"]);

        if ($validarImagen !== false) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $archivo)) {
                $nombreImagen = basename($_FILES["imagen"]["name"]);
            } else {
                $_SESSION['mensaje'] = "Error al subir la nueva imagen.";
                header('Location: ../PHP/AdminPanel.php');
                exit;
            }
        } else {
            $_SESSION['mensaje'] = "El archivo no es una imagen válida.";
            header('Location: ../PHP/AdminPanel.php');
            exit;
        }
    }

    // Actualizar el post en la base de datos
    $query = $mysqli->prepare("UPDATE Posts SET Title = ?, Resume = ?, Content = ?, Image = ? WHERE Code = ?");
    $query->bind_param("ssssi", $titulo, $resumen, $contenido, $nombreImagen, $postId);
    if ($query->execute()) {
        $_SESSION['mensaje'] = "Post actualizado con éxito.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el post: " . $mysqli->error;
    }

    $mysqli->close();
    header('Location: ../PHP/AdminPanel.php');
    exit;
} else {
    $_SESSION['mensaje'] = "No se recibieron datos.";
    header('Location: ../PHP/AdminPanel.php');
    exit;
}
?>
