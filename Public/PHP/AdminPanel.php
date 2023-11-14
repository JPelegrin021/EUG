<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link rel="stylesheet" href="../CSS/AdminPanel.css">
    <script defer src="../JS/AdminPanel.js"></script>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
<?php 
session_start(); 
include '../DB/dbconnect.php';


if (!isset($_SESSION['usuario']) || $_SESSION['admin'] != 1) {
    $_SESSION['mensaje'] = "No tienes permiso para realizar esta acción.";
    header('Location: ../PHP/blog.php');
    exit;
}
?>
<header>
    <img style="max-widht: 85px !important;" src="../Assets/thumbnail_Captura.png" alt="logo">
    <h1 style="color:white;">AdminPanel</h1>
    <nav>
        <a href="../../index.php">Inicio</a>
        <a href="#">Categorías</a>
        <?php
        if (isset($_SESSION['usuario']) && $_SESSION['admin'] == 1) {
            echo '<a href="blog.php">Blog</a>';
            echo '<a href="../Login/logout.php">Cerrar Sesión</a>';
        }
        ?>
    </nav>
</header>

<main>
    <h2 style="color:white;">Posts del Blog</h2>
    <div><button type="button"><a href="postsAdmin.php">Crear Post</a></button></div>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Fecha de Subida</th>
                <th>Título</th>
                <th>Resumen</th>
                <th>Imagen</th>
                <th>Contenido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../AdminPosts/GetPosts.php';
            
            $posts = getPosts($mysqli);
            foreach ($posts as $post) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($post['UserName']) . '</td>';
                echo '<td>' . htmlspecialchars($post['Date']) . '</td>';
                echo '<td>' . htmlspecialchars($post['Title']) . '</td>';
                echo '<td>' . htmlspecialchars($post['Resume']) . '</td>';
                echo '<td><img src="../Posts/Images/' . htmlspecialchars($post['Image']) . '" alt="Imagen del post" style="width: 100px; height: auto;"></td>';
                echo '<td>' . htmlspecialchars($post['Content']) . '</td>';
                echo '<td>
                <form action="../AdminPosts/DeletePosts.php" method="post">
                    <input type="hidden" name="post_id" value="' . htmlspecialchars($post['Code']) . '">
                    <input type="submit" value="Eliminar" onclick="updateActivity(); " return confirm(\'¿Estás seguro de que deseas eliminar este post?\');">
                </form>
              </td>';
              echo '<td>
              <button onclick="updateActivity(); " openEditModal(
                \'' . htmlspecialchars($post['Code']) . '\',
                \'' . htmlspecialchars(addslashes($post['Title'])) . '\',
                \'' . htmlspecialchars(addslashes($post['Resume'])) . '\',
                \'' . htmlspecialchars(addslashes($post['Content'])) . '\',
                \'' . htmlspecialchars(addslashes($post['Image'])) . '\'
              )">Editar</button>
            </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</main>

<!-- Modal de edición de posts -->
<div id="editPostModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="updateActivity(); " closeEditModal()">&times;</span>
        <h2 style="color:white;">Editar Post</h2>
        <form id="editPostForm" action="../AdminPosts/UpdatePosts.php" method="post" enctype="multipart/form-data"  style="background-color:#424242 !important; padding-right:100px;">
            <input type="hidden" name="post_id" id="editPostId">
            <div class="form-group">
                <label for="editTitulo">Título</label>
                <input type="text" name="titulo" id="editTitulo" placeholder="Título del post"  style="background-color:#424242 !important;">
            </div>
            <div class="form-group">
                <label for="editResumen">Resumen</label>
                <textarea name="resumen" id="editResumen" rows="5" placeholder="Resumen del post"  style="background-color:#424242 !important;"></textarea>
            </div>
            <div class="form-group">
                <label for="editContenido">Contenido</label>
                <textarea name="contenido" id="editContenido" rows="10" placeholder="Contenido del post"  style="background-color:#424242 !important;"></textarea>
            </div>
            <div class="form-group">
                <label for="editImagen">Imagen</label>
                <input type="file" name="imagen" id="editImagen">
                <!-- Campo para mantener el nombre de la imagen actual -->
                <input type="hidden" name="imagen_actual" id="editImagenActual">
            </div>
            <div class="form-group">
                <input type="submit" value="Actualizar">
            </div>
        </form>
    </div>
</div>


<!-- Aquí comienza la nueva sección de la tabla de usuarios -->
<section>
    <h2 style="color:white;">Usuarios del Blog</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Admin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php
    include '../AdminUsers/GetUsers.php';
    $users = getUsers($mysqli);
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($user['Code']) . '</td>';
        echo '<td>' . htmlspecialchars($user['UserName']) . '</td>';
        echo '<td>
                <select onchange="changeAdminStatus(' . htmlspecialchars($user['Code']) . ', this.value)">
                    <option value="0"' . ($user['Admin'] == 0 ? ' selected' : '') . '>No</option>
                    <option value="1"' . ($user['Admin'] == 1 ? ' selected' : '') . '>Sí</option>
                </select>
              </td>';
      
        echo '<td>
        <form action="../AdminUsers/DeleteUsers.php" method="post">
            <input type="hidden" name="user_id" value="' . htmlspecialchars($user['Code']) . '">
            <input type="submit" value="Eliminar" onclick="updateActivity(); " return confirm(\'¿Estás seguro de que deseas eliminar este usuario?\');">
        </form>
      </td>';
        echo '</tr>';
    }
    ?>
</tbody>
    </table>
</section>

<footer>
    <p>&copy; 2023 NewsWave</p>
</footer>
        </body>
        </html>