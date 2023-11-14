<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Publicar - Posts</title>
  <script defer src="../JS/posts.js"></script>
  <link rel="stylesheet" href="../CSS/posts.css">
  <link rel="stylesheet" href="../CSS/styles.css">
</head>
<style>

</style>
<body>
<?php
      if (isset($_SESSION['usuario'])) {
          echo '<span>Hola, ' . htmlspecialchars($_SESSION['usuario']) . '</span>';
          echo '<a href="../Login/logout.php">Cerrar Sesión</a>';
      } else {
          echo '<a href="#" id="loginBtn">Login</a>';
      }
      ?>
  <header>
    <a href="blog.php">Atrás</a>
    <h1>Publica tu post</h1>
  </header>

  <main>
  <form action="../POSTS/NewPosts.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" placeholder="Título de tu post">
      </div>
      <div class="form-group">
        <label for="resumen">Resumen</label>
        <textarea name="resumen" id="resumen" rows="5" placeholder="Resumen de tu post"></textarea>
      </div>
      <div class="form-group">
        <label for="contenido">Contenido</label>
        <textarea name="contenido" id="contenido" rows="10" placeholder="Contenido de tu post"></textarea>
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen">
      </div>
      <div class="form-group">
        <input type="submit" value="Publicar">
      </div>
    </form>
  </main>

  <footer>
    <p>Copyright &copy; 2023 NewsWave</p>
  </footer>
</body>
</html>