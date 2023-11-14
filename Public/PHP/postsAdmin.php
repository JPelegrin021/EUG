<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Página de publicación</title>
  <link rel="stylesheet" href="../CSS/posts.css">
  <link rel="stylesheet" href="../CSS/styles.css">
</head>
<style>

</style>
<body>
<?php
        session_start();
        include '../DB/dbconnect.php';

        // Comprobar si el usuario es administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['admin'] != 1) {
            $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción.";
            header('Location: ../PHP/blog.php');
            exit;
        }
      ?>
  <header>
    <a href="AdminPanel.php">Atrás</a>
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