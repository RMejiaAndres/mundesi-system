<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bienvenido Administrador</h1>
    <nav>
        <ul>
            <li><a href="manage_users.php">Gestionar Usuarios</a></li>
            <li><a href="manage_schedules.php">Horarios y Citas</a></li>
            <li><a href="manage_reports.php">Reportes Financieros</a></li>
            <li><a href="settings.php">Configuración del Sistema</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</body>
</html>
