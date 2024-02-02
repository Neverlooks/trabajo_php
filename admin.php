<?php
// Activa la visualización de errores en el navegador
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('server/connection.php');
session_start();

// Verificar si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    // Si el usuario no es un administrador, redirigirlo a la página principal
    echo "Acceso denegado. Debes ser administrador para acceder a esta página.";
    
    header("Location: index.php");
    exit;
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

<section class="container my-5 py-5">
    <h2> <?php echo "Bienvenido, " . $_SESSION["username"] . " (Rol: Administrador)"; ?></h2>
    <h1>Panel de Administración de Productos</h1>
</section>

<?php
// Consulta SQL para obtener la lista de productos
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>
<section class="admin-data container">
    <table class="mt-5 pt-5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Precio</th>
            <th>Descripción</th>
            <th>Color</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['product_id']; ?></td>
                <td><?php echo $row['product_name']; ?></td>
                <td><?php echo $row['product_category']; ?></td>
                <td><?php echo $row['product_price']; ?></td>
                <td><?php echo $row['product_description']; ?></td>
                <td><?php echo $row['product_color']; ?></td>
                <td>
                    
                    <a href="editar_prod.php?id=<?php echo $row['product_id']; ?>">Editar</a>
                    <button onclick="confirmDeleteProd(<?php echo $row['product_id']; ?>)">Eliminar</button>
                    <script>
                        function confirmDeleteProd(productId) {
                            var result = confirm("¿Estás seguro de que deseas eliminar este producto?");
                            
                            if (result) {
                                // Si el usuario confirma, redirige a la página de eliminación del producto
                                window.location.href = "eliminar_prod.php?id=" + productId;
                            }
                        }
                    </script>

                </td>
            </tr>
        <?php } ?>
    </table>
    
    <div>
        <a href="agregar_prod.php">Agregar Producto</a>
    </div>
</section>

<!--              Administrar Usuarios                  -->

<section class="container my-3 py-3">
    <h1>Panel de Administración de Usuarios</h1>
</section>

<?php
// Consulta SQL para obtener la lista de usuarios
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<section class="admin-data container">
    <table class="mt-5 pt-5">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Contraseña</th>
            <th>Rol</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['user_password']; ?></td>
                <td><?php echo $row['role']; ?></td>
                <td>
                    <a href="editar_user.php?id=<?php echo $row['user_id']; ?>">Editar</a>
                    <button onclick="confirmDeleteUser(<?php echo $row['user_id']; ?>)">Eliminar</button>
                    <script>
                        function confirmDeleteUser(userId) {
                            var result = confirm("¿Estás seguro de que deseas eliminar este usuario?");
                            
                            if (result) {
                                // Si el usuario confirma, redirige a la página de eliminación del usuario
                                window.location.href = "eliminar_user.php?id=" + userId;
                            }
                        }
                    </script>
                </td>
            </tr>
        <?php } ?>
    </table>
    
    <div>
        <a href="agregar_user.php">Agregar Usuario</a>
    </div>

        <!-- Botón para cerrar sesión -->
        <div class="container py-3 my-3">
        <form action="logout.php" method="post">
            <input id="cerrar-sesion" type="submit" value="Cerrar Sesión">
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