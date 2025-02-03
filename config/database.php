<?php
$host = "localhost";
$user = "root"; // Cambiar si tienes un usuario diferente
$pass = ""; // Dejar vacío si no tienes contraseña en XAMPP
$dbname = "mundesi_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
