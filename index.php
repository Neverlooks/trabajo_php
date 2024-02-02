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
          <a class="nav-link" href="#">Home</a>
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

<!-- Inicio -->
<section id="inicio">
    <div class="container">
        <h3>NOVEDADES</h3>
        <h1>Descubre las <span>mejores ofertas</span></h1>
        <button>Compra Ahora</button>
    </div>
</section>

<!-- Proveedores -->
<section id="proveedores" class="container">
  <div class="row">
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/proveedor1.jpg"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/proveedor2.jpg"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/proveedor3.jpg"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/imgs/proveedor4.jpg"/>
  </div>
</section>

<!-- Novedades -->
<section id="novedades" class="w-100">
  <div class="row p-0 m-0">
    <!-- Artículo 1 -->
    <div class="nuevo col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/imgs/nuevo1.jpg">
      <div class="detalles">
        <h2>Las zapatillas más variadas</h2>
        <button class="text-uppercase">Comprar</button>
      </div>
    </div>
    <!-- Artículo 2 -->
    <div class="nuevo col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/imgs/nuevo2.jpg">
      <div class="detalles">
        <h2>Las mejores camisetas</h2>
        <button class="text-uppercase">Comprar</button>
      </div>
    </div>
    <!-- Artículo 3 -->
    <div class="nuevo col-lg-4 col-md-12 col-sm-12 p-0">
      <img class="img-fluid" src="assets/imgs/nuevo3.jpg">
      <div class="detalles">
        <h2>50% descuento en relojes</h2>
        <button class="text-uppercase">Comprar</button>
      </div>
    </div>

  </div>
</section>

<!-- Destacados-->
<section id="destacados">
  <div class="container text-center mt-5 py-5">
    <h3>Nuestros destacados</h3>
    <hr class="mx-auto">
    <p>Aquí puedes echar un vistazo a nuestros Best-Sellers</p>
  </div>

  <div class="row mx-auto container-fluid">
  
    <?php include('server/get_prod_destacados.php')?>
    <?php while($row = $prod_destacados->fetch_assoc()){ ?>

        <div class="productos text-center col-lg-3 col-md-4 col-sm-12">
          <img class="img-fluid mb-3" src="assets/imgs/Prod-Destacados/<?php echo $row['product_image']; ?>">
          <div class="star">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
          <h5 class="p-nombre"><?php echo $row['product_name']; ?></h5>
          <h4 class="p-precio">€ <?php echo $row['product_price']; ?></h4>

          <form method="POST" action="cart.php">
            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"> 
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
            <button class="add_cart" type="submit" name="add_to_cart" >Añadir al carrito</button>
          </form>
        </div>



      <?php } ?>
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