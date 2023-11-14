<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario</title>
    <link rel="stylesheet" href="../CSS/perfil.css">
    <script defer src="../JS/perfil.js"></script>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
<?php 
session_start(); 
include '../Posts/getPostsByUser.php'; // Incluye el archivo getPostsByUser.php
include '../Posts/getActiveUsers.php';
include '../Posts/getLikedPostsByUser.php';

if (!isset($_SESSION['usuario'])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para ver esta página.";
    header('Location: ../PHP/blog.php');
    exit;
}

// Obtener posts del usuario
$userId = $_SESSION['usuario_id']; // Asegúrate de que esta es la clave correcta
$posts = getPostsByUser($mysqli, $userId);

$likedPosts = getLikedPostsByUser($mysqli, $userId);
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
       echo "<button style='display:none;' class='" . $likeButtonClass . "' onclick='addLike(" . $post['Code'] . ")' data-post-code='" . $post['Code'] . "'></button>";
   }
   echo '<span class="like-count" data-post-code="' . $post['Code'] . '">' . $likeCount . ' likes</span>';
   echo '</div>';
   echo '</div>';
}
echo '</div>';
?>

</main>
 <!-- Sesction Usuarios COnectados -->
 <section>
 <h2>Usuarios Conectados</h2>
    <ul>
        <?php foreach ($activeUsers as $user): ?>
            <!-- Asumiendo que $user sea el nombre de usuario -->
            <li><a href="perfil_usuario.php?username=<?= urlencode($user) ?>" style="background-color: #06f; padding: 10px 20px; color: #ffffff; text-decoration: none; border-radius: 5px; margin-left: 1%;"><?= htmlspecialchars($user) ?></a></li>
        <?php endforeach; ?>
    </ul>
 </section>

 <!-- Sección de Posts con Like -->
<section>
    <h2>Posts que te Gustan</h2>
    <?php
    echo '<div class="cards">';
         foreach ($likedPosts as $post) {
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
</section>

<footer>
    <p>&copy; 2023 NewsWave</p>
</footer>
</body>
</html>