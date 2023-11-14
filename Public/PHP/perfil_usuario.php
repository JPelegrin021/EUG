<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
session_start(); 
include '../DB/dbconnect.php';
include '../Posts/getPostsByUserC.php';

$username = $_GET['username'] ?? '';

if (!$username) {
    // Manejar el error o redirigir
    echo 'Usuario no especificado.';
    exit;
}

// Obtener posts del usuario especificado
$posts = getPostsByUserC($mysqli, $username);
?>

<header>
 <h1>Perfil de <?= htmlspecialchars($username) ?></h1>
</header>

<main>
    <div class="cards">
        <?php foreach ($posts as $post): ?>
            <div class="post-card">
                <h2><?= htmlspecialchars($post['Title']) ?></h2>
                <div class="username">Publicado por: <?= htmlspecialchars($post['UserName']) ?></div>
                <div class="divImg">
                    <img src="../Posts/Images/<?= htmlspecialchars($post['Image']) ?>" alt="Imagen del post" style="width: 400px; height: 200px; justify-content: center;">
                </div>
                <div class="content"><?= htmlspecialchars($post['Resume']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer>
    <!-- Aquí tu código de pie de página -->
</footer>
</body>
</html>
