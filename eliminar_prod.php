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

    // Realizar una consulta SQL para eliminar el producto
    $delete_query = "DELETE FROM products WHERE product_id = $product_id";
    
    if (mysqli_query($conn, $delete_query)) {
        // Redirigir al administrador de vuelta a la página de administración con mensaje de éxito
        header("Location: admin.php");
        echo '<script>alert("El producto ha sido eliminado");</script>';
        exit;
    } else {
        // Mostrar mensaje de error si la eliminación falla
        $error_message = "Error al intentar eliminar el producto: " . mysqli_error($conn);
        echo '<script>alert("Error al intentar eliminar el producto: ' . mysqli_error($conn) . '");</script>';
    }
} else {
    // El ID del producto no se proporcionó
    header("Location: admin.php");
    exit;
}
?>

