<?php
session_start();
$mensaje ="";
if(isset($_SESSION['mensaje'])){
  $mensaje = $_SESSION['mensaje'];
  unset($_SESSION['mensaje']); //Crida al missatge de la sesió
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Inici</title>
  <script defer src="../JS/index.js"></script>
  <link rel="stylesheet" href="Public/CSS/Index.css">
  <link rel="stylesheet" href="Public/CSS/style.css">
</head>
<body>
<?php if (!empty($mensaje)): ?>

    <script>alert('<?php echo addslashes($mensaje);?>');</script>
    <?php endif; ?>

  <header>
  <img src="./Public/Assets/thumbnail_Captura.png" alt="logo">
  <h1 style="color:white;">Home</h1>
    <nav>
      <a href="#qs">Quiénes somos</a>
      <a href="Public/PHP/blog.php">Blog</a>
      <?php
    if (isset($_SESSION['usuario'])) {
   // Si el usuario es administrador, mostrar el botón del panel de administración
        if ($_SESSION['admin'] == 1) {
            echo '<a href="Public/PHP/AdminPanel.php">AdminPanel</a>';
        }

        echo '<a href="Public/Login/logout.php">Cerrar Sesión</a>';
        $saludo = $_SESSION['admin'] == 1 ? "Hola, " . htmlspecialchars($_SESSION['usuario']) . ", Admin" : "Hola, " . htmlspecialchars($_SESSION['usuario']);
        echo '<a href="Public/PHP/perfil.php" style="font-size: 10px">', '<span class="spanSaludo">' . $saludo . '</span>','</a>';
    } else {
        echo '<a href="Public/PHP/blog.php" id="loginBtn">Login</a>';
    }
    ?>
    </nav>
  </header>

  <section id="mapa">
    <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=New%20York+(Your%20Business%20Name)&amp;t=k&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.gps.ie/sport-gps/">hiking gps</a></iframe>
  </section>

  <section id="contenido">
    <div id="qso" class="tarjeta">
    <div id="qs">
    <h2>Quiénes somos</h2>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed condimentum metus ornare lectus consectetur, et rutrum ligula ultricies. Nullam lobortis vehicula laoreet. Sed ac tristique condimentum interdum, Duis malesuada mattis diam et feugiat. Duis condimentum nibh a massa congue facilisis.
    </p>
    </div>
    <div id="qo">
    <h2>Qué ofrecemos</h2>
    <p>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed condimentum metus ornare lectus consectetur, et rutrum ligula ultricies. Nullam lobortis vehicula laoreet. Sed ac tristique condimentum interdum, Duis malesuada mattis diam et feugiat. Duis condimentum nibh a massa congue facilisis.
    </p>
    </div>
   </div>
    <div id="cntsp" class="tarjeta">
    <div id="Contacto">
    <h2>Contacto</h2>
    <form action="#">
      <input type="text" placeholder="Nombre">
      <input type="email" placeholder="Email">
      <input type="checkbox" placeholder="Quiere recibir novedades?">
      <input type="tel" placeholder="Telefono">
      <input type="text" placeholder="Mensaje">
      <button type="submit">Enviar</button>
    </form>
  </div>
    <img src="Public/Assets/partners.jpg" alt="Partners" class="prtnr">
    </div>
  </section>

  <footer>
    <p>Copyright &copy; 2023 NewsWave</p>
  </footer>

</body>
</html>
<?php 
     ?>