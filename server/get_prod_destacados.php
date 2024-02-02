<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products LIMIT 12");

$stmt->execute();

$prod_destacados = $stmt->get_result();

?>