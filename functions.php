<?php

function verificarSesion() {
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit;
    }
}


function agregarAlCarrito($post) {
    $product_id = $post['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        // El producto ya está en el carrito
        echo '<script>alert("El producto ya ha sido añadido");</script>';
    } else {
        // El producto no está en el carrito, lo añadimos
        $product_name = $_POST['product_name'];
        $product_image = $_POST['product_image'];
        $product_price = $_POST['product_price'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $post['product_name'],
            'product_image' => $post['product_image'],
            'product_price' => $post['product_price'],
            'product_quantity' => 1
        );

        $_SESSION['cart'][$product_id] = $product_array;
    }
}

function borrarDelCarrito($product_id) {
    unset($_SESSION['cart'][$product_id]);
}

// functions.php

function realizarCompra() {
    // Inicializar una variable para el costo total
    $total_cost = 0;

    // Comprobar si el carrito no está vacío
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            // Calcular el costo total sumando el precio del producto por la cantidad
            $total_cost += $product['product_price'] * $product['product_quantity'];
        }
    }

    // Obtener el ID del usuario actual desde la sesión
    $user_id = $_SESSION['user_id'];

    // Obtener la fecha y hora actual
    $order_date = date("Y-m-d H:i:s");

    // Realizar la inserción en la tabla de historial de compras (orders)
    $query = "INSERT INTO orders (user_id, order_cost, order_date) VALUES ('$user_id', '$total_cost', '$order_date')";

    // Ejecutar la consulta SQL
    global $conn; // Asegurarse de que $conn esté disponible en este contexto
    if (mysqli_query($conn, $query)) {
        // Eliminar los productos del carrito después de la compra
        unset($_SESSION['cart']);

        // Redirigir a una página de confirmación de compra o a donde desees
        header('Location: index.php');
        exit();
    } else {
        // Manejo de error en caso de que la consulta no se ejecute correctamente
        echo "Error al realizar la compra: " . mysqli_error($conn);
    }
}

// Función para editar la cantidad de los productos en carrito

function editCantidad($product_id, $new_quantity) {
    // Verificar si el producto está en el carrito
    if (isset($_SESSION['cart'][$product_id])) {
        // Actualizar la cantidad del producto en el carrito
        $_SESSION['cart'][$product_id]['product_quantity'] = $new_quantity;
        return true; // Indicar que la actualización fue exitosa
    }

    return false; // Indicar que el producto no se encontró en el carrito
}


?>