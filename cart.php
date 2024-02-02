<?php

include('server/connection.php');
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])) {
  // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
  header("Location: login.php");
  exit;
}

// Para añadir al carrito
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['cart'][$product_id])) {
        echo '<script>alert("El producto ya ha sido añadido");</script>';
    } else {
        // Si el producto no está en el carrito, lo añadimos
        $product_name = $_POST['product_name'];
        $product_image = $_POST['product_image'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_image' => $product_image,
            'product_price' => $product_price,
            'product_quantity' => 1
        );

        // Almacenar el producto en el carrito
        $_SESSION['cart'][$product_id] = $product_array;
    }
}

// Borrado de productos del carrito
if (isset($_POST['borrar-prod'])) {
    $product_id = $_POST['product_id'];
    // Eliminar un producto del carrito
    unset($_SESSION['cart'][$product_id]);
}

// Botón comprar final
if (isset($_POST['comprar'])) {
    // Calcular el costo total del carrito
    $total_cost = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total_cost += $product['product_price'] * $product['product_quantity'];
        }
    }

    $user_id = $_SESSION['user_id']; // Obtenemos el ID del usuario actual desde la sesión
    $order_date = date("Y-m-d H:i:s"); // Obtenemos la fecha y hora actual

    if (!empty($_SESSION["user_id"]) && is_numeric($_SESSION["user_id"])) {
      // El valor de $_SESSION["user_id"] es válido, realizamos la inserción en la tabla "orders"
    } else {
      // Maneja el caso en el que $_SESSION["user_id"] no es válido
      echo "Error: user_id no válido";
    }

    // Insertar la orden en la tabla de historial de compras
    $query = "INSERT INTO orders (user_id, order_cost, order_date) VALUES ('$user_id', '$total_cost', '$order_date')";
    // Ejecuta la consulta SQL
    if (mysqli_query($conn, $query)) {
      // Eliminar los productos del carrito
      unset($_SESSION['cart']);

      // Redirigir a la página de usuario para ver el historial de compra
      header('Location: usuario.php');
      exit();

    }else {
      // Manejo de error en caso de que la consulta no se ejecute correctamente
      echo "Error al realizar la compra: " . mysqli_error($conn);
  }
}

// Botón editar cantidad
if (isset($_POST['edit_quantity'])) {
  $product_id = $_POST['edit_quantity'];
  $new_quantity = $_POST['product_quantity'][$product_id];

  // Actualiza la cantidad del producto en el carrito
  if (isset($_SESSION['cart'][$product_id])) {
      $_SESSION['cart'][$product_id]['product_quantity'] = $new_quantity;
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
            <a href="cart.php"><i class="fas fa-brands fa-opencart"></i></a>
            <a href="./usuario.php"><i class="fas fa-user"></i></a>
        </li>
          
        </ul>
  
      </div>
    </div>
</nav>
  
<!-- Carrito --> 
<section class="carrito container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bolder">Su Carrito</h2>
        <hr>
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>

      <!-- Visualización y validación del carrito -->  
      <?php 
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
          foreach($_SESSION['cart'] as $key => $value) { ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/Prod-Destacados/<?php echo $value['product_image']; ?>" alt="">
                        <div>
                            <p><?php echo $value['product_name']; ?></p>
                            <small><span>€ </span><?php echo $value['product_price']; ?></small>
                            <br>
                            <form method="post" action="cart.php">
                              <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                              <input type="submit" class="borrar-btn" name="borrar-prod" value="Borrar"/>
                            </form>
                        </div>
                    </div>
                </td>
                <!-- Botón editar cantidad -->
                <td>
                  <form method="post" action="cart.php">
                    <input type="number" name="product_quantity[<?php echo $product_id; ?>]" value="<?php echo $value['product_quantity']; ?>">
                    <button type="submit" name="edit_quantity" value="<?php echo $product_id; ?>">Editar</button>
                    <span>Cantidad: <?php echo $value['product_quantity']; ?></span>
                  </form>
                </td>
                <!-- Cálculo del precio total por producto-->
                <td>
                    <span>€ </span>
                    <span class="precio-producto"><?php echo $value['product_quantity'] * $value['product_price']; ?></span>
                </td>
            </tr>
          <?php }
      }else {
        // Si $_SESSION['cart'] no está definido o no es un array válido
        echo "El carrito está vacío.";
    } ?>

    <!-- Botón Comprar -->
    </table>
    <form method="POST">
      <button type="submit" class="container compra-btn mt-5" name="comprar">Comprar</button>
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