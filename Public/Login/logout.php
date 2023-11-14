<?php
session_start();
session_destroy(); // Destruye todos los datos de la sesión
header('Location: ../PHP/blog.php'); // Redirige al usuario
exit;
?>