<?php

// Activa la visualización de errores en el navegador
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('server/connection.php');
session_start();

// Comprobar si el usuario está autenticado como administrador
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    // Redirigir al usuario normie a la página principal
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST["product_name"];
    $product_category = $_POST["product_category"];
    $product_price = $_POST["product_price"];
    $product_description = $_POST["product_description"];
    $product_color = $_POST["product_color"];
   
    // Manejo del archivo de imagen
    $product_image = $_FILES["product_image"]["name"]; // Nombre del archivo
    $temp_image = $_FILES["product_image"]["tmp_name"]; // Archivo temporal

    // Mover el archivo de imagen a la ubicación de todas las imágenes
    $image_destination = "./assets/imgs" . $product_image;
    move_uploaded_file($temp_image, $image_destination);

    // Realizar la consulta SQL para agregar el producto
    $insert_query = "INSERT INTO products (product_name, product_category, product_price, product_description, product_color, product_image) 
      VALUES ('$product_name', '$product_category', '$product_price', '$product_description', '$product_color', '$product_image' )";
    
    if (mysqli_query($conn, $insert_query)) {
        // Redirigir al administrador de vuelta a la página de administración con mensaje de éxito
        header("Location: admin.php");
        echo '<script>alert("El producto ' . $product_name . ' ha sido agregado");</script>';
        exit;
    } else {
        // Mensaje de error si la inserción falla
        $error_message = "Error al intentar agregar el producto: " . mysqli_error($conn);
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
    <section class="add-product container my-5 py-5">
    <h1>Añadir Nuevo Producto</h1>
    <form method="POST" action="agregar_prod.php" enctype="multipart/form-data">
        <label for="product_name">Nombre del Producto:</label>
        <input type="text" name="product_name" required><br>

        <label for="product_category">Categoría:</label>
        <input type="text" name="product_category" required><br>

        <label for="product_price">Precio:</label>
        <input type="number" step="0.01" name="product_price" required><br>

        <label for="product_description">Descripción:</label>
        <textarea name="product_description" required></textarea><br>

        <label for="product_color">Color:</label>
        <input type="text" name="product_color" required><br>

        <label for="product_image">Imagen del Producto:</label>
        <input type="file" name="product_image" accept="imgs/*"><br>

        <input type="submit" value="Agregar Producto">
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
