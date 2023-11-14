<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Posts</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script defer src="../JS/blog.js"></script>
  <link rel="stylesheet" href="../CSS/blog.css">
  <link rel="stylesheet" href="../CSS/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
  <?php session_start();
    include '../Posts/GetPosts.php';
    
  $search = isset($_GET['search']) ? $_GET['search'] : null;
  $posts = getPosts($mysqli, $search);
  ?>

  <header>
    <img  src="../Assets/thumbnail_Captura.png" alt="logo">
    <h1>Blog de productos</h1>
    <nav>
      <a href="../../index.php">Inicio</a>
      <?php
    if (isset($_SESSION['usuario'])) {
        if ($_SESSION['admin'] == 1) {
            echo '<a href="AdminPanel.php">AdminPanel</a>';
        }

        echo '<a href="../Login/logout.php">Cerrar Sesión</a>';
        $saludo = $_SESSION['admin'] == 1 ? "Hola, " . htmlspecialchars($_SESSION['usuario']) . ", Admin" : "Hola, " . htmlspecialchars($_SESSION['usuario']);
        echo '<a href="perfil.php" style="font-size: 10px">', '<span class="spanSaludo">' . $saludo . '</span>','</a>';
    } else {
        echo '<a href="#" id="loginBtn">Login</a>';
    }
    ?>
    </nav>
  </header>

  <section id="contenido">
    <div class="searchbar">
    <form action="blog.php" method="get">
        <input type="text" name="search" placeholder="Buscar..." class="inputBuscar">
        <button type="submit">Buscar</button>
    </form>
      <button type="button"><a href="posts.php">Crear Post</a></button>
    </div>


    <?php if (isset($_SESSION['mensaje'])): ?>
      <p><?php echo $_SESSION['mensaje']; ?></p>
      <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (!isset($_SESSION['usuario'])): ?>
      <div id="loginModal" class="modal">
        <div class="modal-content" style="background-color:#2E2E2E;">
          <button class="close" id="closeBtn">x</button>
          <h2>Iniciar sesión</h2>
          <form action="../Login/login.php" method="post" id="login">
          <div class="form-group">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username">
          </div>
          <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
          </div>
          <button type="submit" id="login" style="background-color: #06f; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Iniciar sesión</button>
          <p>O <a id="registerBtn">Regístrate</a></p>
        </form>

        </div>
      </div>
    <?php endif; ?>

    <!-- Contenido del Formulario de Registro -->
    <?php if (!isset($_SESSION['usuario'])): ?>
      <div id="registerModal" class="modal">
        <div class="modal-content" style="background-color:#2E2E2E;">
          <button class="close" id="closeBtnR">&times;</button>
          <h2>Registrar</h2>
          <form action="../Register/register.php" method="post" id="register">
            <div class="form-group">
              <label for="username">Usuario:</label>
              <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Contraseña:</label>
              <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" id="register" style="background-color: #06f; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Registrar</button>
            <p>O <a onclick="updateActivity(); " id="loginTB">Logeate</a></p>
          </form>
        </div>
      </div>
    <?php endif; ?>
  </section>

  <section>
    
  <?php

echo '<div class="cards">';
  foreach ($posts as $post) {
    echo '<div class="post-card" style="display:grid;">';
    echo '<h2>' . htmlspecialchars($post['Title']) . '</h2>';
    echo '<div class="username">Publicado por: <a href="perfil_usuario.php?username=' . urlencode($post['UserName']) . '">' . htmlspecialchars($post['UserName']) . '</a> ' . htmlspecialchars($post['Date']) . '</div>';
    echo '<div class="divImg"><img src="../Posts/Images/' . htmlspecialchars($post['Image']) . '" alt="Imagen del post" onclick="updateActivity(); openModal(\'' . htmlspecialchars($post['Title']) . '\', \'../Posts/Images/' . htmlspecialchars($post['Image']) . '\', \'' . htmlspecialchars($post['Content']) . '\', ' . $post['Code'] . ')"></div>';

    echo '<div class="content">' . htmlspecialchars($post['Resume']) . '</div>';
    if (isset($_SESSION['usuario']) && $_SESSION['usuario_id'] == $post['User']) {
      echo '<button class="edit-btn" onclick="updateActivity(); openEditModal(\'' . $post['Code'] . '\')" style="background-color: #06f; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" >Editar</button>';
    }
    
    if (isset($_SESSION['usuario'])) {
      echo '<form action="../Posts/AddComment.php" method="post" class="formComment">';
      echo '<input type="hidden" name="postCode" value="' . htmlspecialchars($post['Code']) . '">';
      echo '<input type="hidden" name="userCode" value="' . htmlspecialchars($_SESSION['usuario_id']) . '">';
      echo '<textarea name="comment" placeholder="Añade un comentario..." required class="CommentArea"></textarea>';
      echo '<button type="submit" class="publish">Send</button>';
      echo '</form>';
  }
  // Obtén el total de likes para el post actual
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
      echo "<button class='" . $likeButtonClass . "' onclick='addLike(" . $post['Code'] . ")' data-post-code='" . $post['Code'] . "'></button>";
  }
  echo '<span class="like-count" data-post-code="' . $post['Code'] . '">' . $likeCount . ' likes</span>';
  echo '</div>';

    echo '</div>';
}

echo '</div>';
  ?>
  </section>
  <div id="editModal" class="modal" style="display: none;">
  <div class="modal-content" style=" background-color:#424242 !important;">
    <button class="close" id="closeEditBtn">&times;</button>
    <h2>Editar Post</h2>
    <form id="editPostForm">
      <input type="hidden" id="editPostId">
      <div class="form-group">
        <label for="editTitle">Título:</label>
        <input type="text" id="editTitle" name="title">
      </div>
      <div class="form-group">
        <label for="editSummary">Resumen:</label>
        <textarea id="editSummary" name="summary"></textarea>
      </div>
      <button type="submit"  style="background-color: #06f; color: white; border: none; padding: 10px 15px; border-radius:5px;">Actualizar</button>
    </form>
  </div>
</div>

<!-- Modal para mostrar la imagen y el contenido del post -->
<div id="postModal" class="modal" style="display: none; ">
    <div class="modal-content" style="background-color:#424242;" >
        <span class="close" onclick="updateActivity(); closeModal()">&times;</span>
        <h2 id="postTitle"></h2>
        <img id="postImage" src="" alt="Imagen del Post" style="max-width: 100%;">
        <p id="postContent"></p>
        <div id="postComments"></div>
    </div>
</div>


  <footer>
    <p>&copy; 2023 NewsWave</p>
  </footer>
</body>
</html>

