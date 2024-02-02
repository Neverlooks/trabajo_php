<?php
include('server/connection.php');
session_start();

// Comprobar si el usuario tiene permiso para editar usuarios
if (!isset($_SESSION["username"]) || $_SESSION["user_role"] !== "admin") {
    // Redirigir al usuario normie a la página de inicio 
    header("Location: index.php");
    exit;
}

// Obtener el ID del usuario de la URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Realizar una consulta SQL para obtener la información del usuario
    $selectQuery = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $selectQuery);

    if ($row = mysqli_fetch_assoc($result)) {
        // Los datos del usuario se obtuvieron correctamente, ahora se muestra el formulario de edición
        $name = $row['user_name'];
        $email = $row['user_email'];
        $role = $row['role'];
    } else {
        // Si no se encontró el usuario
        header("Location: admin.php");
        exit;
    }
} else {
    // El ID del usuario no se proporcionó
    header("Location: admin.php");
    exit;
}

// Procesar el formulario de edición si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = $_POST["new_name"];
    $newEmail = $_POST["new_email"];
    $newRole = $_POST["new_role"];

    // Realizar una consulta SQL para actualizar la información del usuario
    $updateQuery = "UPDATE users SET user_name = '$newName', user_email = '$newEmail', role = '$newRole' WHERE user_id = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirigir al administrador de vuelta a la página de administración de usuarios con un mensaje de éxito
        header("Location: admin.php");
        echo '<script>alert("Los datos del usuario han sido actualizados");</script>';
        exit;
    } else {
        // Mostrar mensaje de error si la actualización falla
        $error_message = "Error al intentar actualizar los datos del usuario: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome directory -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    
</head>
<body>
    <section class="edit-prod container my-5 py-5">
        <h1>Editar Usuario</h1>
        <form method="POST" action="editar_user.php?id=<?php echo $userId; ?>">
            <label for="new_name">Nombre del Usuario:</label>
            <input type="text" name="new_name" value="<?php echo $name; ?>" required><br>
            <label for="new_email">Email:</label>
            <input type="text" name="new_email" value="<?php echo $email; ?>" required><br>
            <label for="new_role">Rol:</label>
            <select name="new_role">
                <option value="admin" <?php if ($role === 'admin') echo 'selected'; ?>>Administrador</option>
                <option value="user" <?php if ($role === 'user') echo 'selected'; ?>>Usuario</option>
            </select><br>
            <input type="submit" value="Guardar Cambios">
        </form>
    </section>
</body>
</html>
