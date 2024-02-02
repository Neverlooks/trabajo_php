<?php
// Activa la visualización de errores en el navegador
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('server/connection.php');
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar el nombre de usuario y contraseña ingresados 
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Realizar una consulta SQL para verificar las credenciales en la base de datos
    $query = "SELECT * FROM users WHERE user_name = '$username' AND user_password = '$password'";
    $result = mysqli_query($conn, $query);

    // Verificar si la consulta fue exitosa y si se encontró un registro con las credenciales
    if (mysqli_num_rows($result) == 1) {
        // Credenciales válidas, iniciar la sesión
        $row = mysqli_fetch_assoc($result);
        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $row["user_id"]; // Establecer el user_id en la sesión
        $_SESSION["user_role"] = $row["role"]; // Establecer el rol en la sesión

      // Si es admin o usuario normie, redirigimos al adecuado
      if ($_SESSION["user_role"] == "admin") {
          header("Location: admin.php");
      } else {
          header("Location: usuario.php");
      }
      exit;

    } else {
        // Credenciales inválidas
        $error_message = "Nombre de usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome directory -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">

    <div class="container">
      <!-- Logotipo -->
      <img id="logo" src="assets/imgs/logo.png">
  
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
  
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
        <li class="nav-item">
            <a href="./cart.php"><i class="fas fa-brands fa-opencart"></i></a>
            <a href="./usuario.php"><i class="fas fa-user"></i></a>
        </li>
          
        </ul>
  
      </div>
    </div>
  </nav>

<!-- Login -->
<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2>Iniciar Sesión</h2>

    </div>
    <div class="mx-auto container">
        <form method="POST" action="login.php" id="login-form">
            <div class="form-group">
                <label for="">Nombre de usuario</label>
                <input type="text" class="form-control" id="login-email" name="username" placeholder="Nombre de Usuario" required>
            </div>
            <div class="form-group">
                <label for="">Contraseña</label>
                <input type="text" class="form-control" id="login-password" name="password" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" value="Login">
            </div>
            <div class="form-group">
                <a id="register-url" class="btn" href="registro.php">¿No tienes una cuenta? Regístrate</a>
            </div>
        </form>
    </div>
</section>


<!-- Footer -->
<footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
      <div class="footer-one col-lg-4 col-md-8 col-sm-12">
        <img src="assets/imgs/logo.png">
        <p class="pt-3">Los mejores productos al mejor precio</p>
      </div>
  
      <div class="footer-one col-lg-4 col-md-8 col-sm-12">
        <h5 class="pb-2">Destacados</h5>
        <ul class="text-uppercase">
          <li><a href="#">Ropa</a></li>
          <li><a href="#">Complementos</a></li>
          <li><a href="#">Relojes</a></li>
          <li><a href="#">Equipo</a></li>
        </ul>
      </div>
  
      <div class="footer-one col-lg-4 col-md-8 col-sm-12">
        <h5 class="pb-2">Contacto</h5>
        <div>
          <h6 class="text-uppercase">Dirección</h6>
          <p>Avda. Rio Nalon 10, Riosa, Asturias, 33160</p>
        </div>
        <div>
          <h6 class="text-uppercase">Teléfono</h6>
          <p>+34 648 856 555</p>
        </div>
        <div>
          <h6 class="text-uppercase">Email</h6>
          <p>deportes.rey@gmail.com</p>
        </div>
      </div>
  
    </div>
  
    <div class="copyright mt-5">
      <div class="row container mx-auto">
        <div class="col-lg-4 col-md-8 col-sm-12 mb-4">
          <img id="payments" src="assets/imgs/payments.png">
        </div>
        <div class="col-lg-4 col-md-8 col-sm-12 mb-4 text-nowrap py-4 mb-2">
          <p>eCommerce @ 2024 All Rights Reserved</p>
        </div>
        <div class="col-lg-4 col-md-8 col-sm-12 mb-4 py-4">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
      </div>
    </div>
  
  </footer>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>