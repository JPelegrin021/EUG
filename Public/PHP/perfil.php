<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <script defer src="../JS/perfil.js"></script>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
session_start(); 
include '../Posts/getPostsByUser.php'; // Incluye el archivo getPostsByUser.php
include '../Posts/getActiveUsers.php';

if (!isset($_SESSION['usuario'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver esta página.";
    header('Location: ../PHP/blog.php');
    exit;
}

// Obtener posts del usuario
$userId = $_SESSION['usuario_id']; // Asegúrate de que esta es la clave correcta
$posts = getPostsByUser($mysqli, $userId);
$activeUsers = getActiveUsers($mysqli);

?>
<header>
    <img style="max-width: 85px !important;" src="../Assets/thumbnail_Captura.png" alt="logo">
    <h1 style="color:white;">Perfil del Usuario</h1>
    <nav>
        <a href="../../index.php">Inicio</a>
        <a href="../PHP/blog.php">Blog</a>
        <a href="../Login/logout.php">Cerrar Sesión</a>
    </nav>
</header>

<main>
    <!-- Mostrar posts en estilo de tarjetas -->
    <div class="cards">
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <h2><?= htmlspecialchars($post['Title']) ?></h2>
                <div class="username">Publicado por: <?= htmlspecialchars($post['UserName']) ?></div>
                <div class="divImg">
                    <img src="../Posts/Images/<?= htmlspecialchars($post['Image']) ?>" alt="Imagen del post"  style="width: 400px; height: 200px; justify-content: center;">
                </div>
                <div class="content"><?= htmlspecialchars($post['Resume']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
 <!-- Sesction Usuarios COnectados -->
 <section>
 <h2>Usuarios Conectados</h2>
    <ul>
        <?php foreach ($activeUsers as $user): ?>
            <!-- Asumiendo que $user sea el nombre de usuario -->
            <li><a href="perfil_usuario.php?username=<?= urlencode($user) ?>"><?= htmlspecialchars($user) ?></a></li>
        <?php endforeach; ?>
    </ul>
 </section>
<footer>
    <p>&copy; 2023 NewsWave</p>
</footer>
</body>
</html>