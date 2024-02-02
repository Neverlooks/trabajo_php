<?php
include('functions.php');
include('server/connection.php');
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
    // Si el usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: login.php");
    exit;
}
// Verificar el rol del usuario
if ($_SESSION["user_role"] === "admin") {
    // Si el usuario es god
    header("Location: admin.php");
    exit;
}

$user_id = $_SESSION['user_id'];
// Consulta SQL para obtener el historial de compras del usuario
$query = "SELECT * FROM orders WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css">
    <!-- Font Awesome directory -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    
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

<section class="historial container my-5 py-5">
    
    <br>
    <h2>Historial de Compras de <?php echo $_SESSION["username"]; ?></h2>
    <table class="mt-5 pt-5">
            <tr>
                <th>ID de Orden</th>
                <th>Costo Total</th>
                <th>Fecha de Compra</th>
        </tr>
        <tbody>
            <?php
                while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['order_id'] . '</td>';
                echo '<td>' . $row['order_cost'] . '</td>';
                echo '<td>' . $row['order_date'] . '</td>';
                echo '</tr>';
                }
            ?>
        </tbody>
    </table>

    <!-- Botón para cerrar sesión -->
    <form action="logout.php" method="post">
        <input id="cerrar-sesion" type="submit" value="Cerrar Sesión">
    </form>
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