<?php
include('server/connection.php');
session_start();

// Comprobar si el usuario tiene permiso para eliminar usuarios
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    // Redirigir al usuario a la página de inicio
    header("Location: index.php");
    exit;
}

// Obtener el ID del usuario de la URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Realizar una consulta SQL para eliminar el usuario
    $deleteQuery = "DELETE FROM users WHERE user_id = $userId";
    
    if (mysqli_query($conn, $deleteQuery)) {
        // Redirigir al administrador de vuelta a la página de administración de usuarios con un mensaje de éxito
        header("Location: admin.php");
        echo '<script>alert("El usuario ha sido eliminado");</script>';
        exit;
    } else {
        // Mostrar mensaje de error si la eliminación falla
        $error_message = "Error al intentar eliminar el usuario: " . mysqli_error($conn);
    }
} else {
    // El ID del usuario no se proporcionó
    header("Location: admin.php");
    exit;
}
?>
