<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <link rel="stylesheet" href="../CSS/perfilusuario.css">
    <link rel="stylesheet" href="../CSS/blog.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script defer src="../JS/perfilusuario.js"></script>
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
    <?php
    echo '<div class="cards">';
         foreach ($posts as $post) {
          echo '<div class="post-card" style="display:grid;">';
          echo '<h2>' . htmlspecialchars($post['Title']) . '</h2>';
          echo '<div class="username">Publicado por: ' . htmlspecialchars($post['UserName']) . ' </div>';
          echo '<div class="divImg">';
          echo '<img src="../Posts/Images/' . htmlspecialchars($post['Image']) . '" alt="Imagen del post" style="width: 400px; height: 200px; justify-content: center;">';
          echo '</div>';
          echo '<div class="Resumen">Resumen:  ' . htmlspecialchars($post['Resume']) . ' </div>';


        $likeQuery = $mysqli->prepare("SELECT COUNT(*) AS likeCount FROM Likes WHERE Post = ?");
        $likeQuery->bind_param("i", $post['Code']);
        $likeQuery->execute();
        $likeResult = $likeQuery->get_result();
        $likeRow = $likeResult->fetch_assoc();
        $likeCount = $likeRow['likeCount'];

        // Botón de like y contador de likes
        echo '<div class="like-section">';
        if (isset($_SESSION['usuario'])) {
            // Verificar si el usuario actual ha dado like a este post
            $userLikedQuery = $mysqli->prepare("SELECT * FROM Likes WHERE User = ? AND Post = ?");
            $userLikedQuery->bind_param("ii", $_SESSION['usuario_id'], $post['Code']);
            $userLikedQuery->execute();
            $userLikedResult = $userLikedQuery->get_result();
            $userLiked = $userLikedResult->num_rows > 0;
        
            // Cambiar clase según si el usuario ha dado like o no
            $likeButtonClass = $userLiked ? 'like-btn fas fa-heart liked' : 'like-btn far fa-heart';
            echo "<button  class='" . $likeButtonClass . "' onclick='addLike(" . $post['Code'] . ")' data-post-code='" . $post['Code'] . "' ></button>";
        }
        echo '<span class="like-count" data-post-code="' . $post['Code'] . '">' . $likeCount . ' likes</span>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
        ?>
</main>

<footer>
    <!-- Aquí tu código de pie de página -->
</footer>
</body>
</html>
