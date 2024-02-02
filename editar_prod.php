<?php

include('server/connection.php');
session_start();

// Comprobar si el usuario está autenticado como administrador
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    // Redirigir al usuario normie a la página de inicio
    header("Location: index.php");
    exit;
}

// Obtener el ID del producto de la URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Realizar una consulta SQL para obtener la información del producto
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);

    // Comprobar si se encontró el producto
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
    } else {
        // El producto no existe
        header("Location: admin.php");
        exit;
    }
} else {
    // El ID del producto no se proporcionó
    header("Location: admin.php");
    exit;
}

// Procesar el formulario de edición cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST["new_name"];
    $new_category = $_POST["new_category"];
    $new_price = $_POST["new_price"];
    $new_description = $_POST["new_description"];
    $new_color = $_POST["new_color"];

    // Realizar una consulta SQL para actualizar el producto en la base de datos
    $update_query = "UPDATE products SET
        product_name = '$new_name',
        product_category = '$new_category',
        product_price = $new_price,
        product_description = '$new_description',
        product_color = '$new_color'
        WHERE product_id = $product_id";

    if (mysqli_query($conn, $update_query)) {
        // Redirigir al usuario a la página de administrador con un mensaje de éxito
        header("Location: admin.php");
        echo '<script>alert("El producto ' . $product['product_name'] . ' ha sido actualizado");</script>';
        exit;
    } else {
        // Mostrar un mensaje de error si la actualización falla
        $error_message = "Error al intentar editar producto: " . mysqli_error($conn);
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
    <section class="edit-prod my-5 py-5">
        <div class="container mt-5">
            <h1 class="font-weight-bolder">Editar Producto</h1>
        </div>
        <form method="POST" class="container my-5 py-5">
            <label for="new_name">Nombre:</label>
            <input type="text" name="new_name" value="<?php echo $product['product_name']; ?>"><br>
            <label for="new_category">Categoría:</label>
            <input type="text" name="new_category" value="<?php echo $product['product_category']; ?>"><br>
            <label for="new_price">Precio:</label>
            <input type="number" step="0.01" name="new_price" value="<?php echo $product['product_price']; ?>"><br>
            <label for="new_description">Descripción:</label>
            <textarea name="new_description"><?php echo $product['product_description']; ?></textarea><br>
            <label for="new_color">Color:</label>
            <input type="text" name="new_color" value="<?php echo $product['product_color']; ?>"><br>
            <input type="submit" value="Guardar Cambios">
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
