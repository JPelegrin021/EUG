<?php
session_start();
include '../DB/dbconnect.php';
include '../Posts/updateLastActivity.php'; 

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $mysqli->prepare("SELECT * FROM Users WHERE UserName = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña con la versión encriptada en la base de datos
        if (password_verify($password, $user['Password'])) {
            // Usuario autenticado correctamente
            $_SESSION['usuario'] = $username;
            $_SESSION['admin'] = $user['Admin']; 
            $_SESSION['usuario_id'] = $user['Code'];
            
            updateLastActivity($mysqli, $user['Code']);
            header('Location: ../PHP/blog.php');
            exit;
        } else {
            $_SESSION['mensaje'] = "Contraseña incorrecta.";
            header('Location: ../PHP/blog.php');
            exit;
        }
    } else {
        $_SESSION['mensaje'] = "Usuario no encontrado.";
        header('Location: ../PHP/blog.php');
        exit;
    }
} else {
    $_SESSION['mensaje'] = "Datos de inicio de sesión no proporcionados.";
    header('Location: ../PHP/blog.php');
    exit;
}
?>
