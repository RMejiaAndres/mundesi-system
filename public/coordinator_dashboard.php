<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "coordinator") {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Coordinador</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bienvenido Coordinador</h1>
    <nav>
        <ul>
            <li><a href="manage_schedules.php">Gestionar Horarios y Citas</a></li>
            <li><a href="view_patients.php">Ver Pacientes</a></li>
            <li><a href="view_reports.php">Reportes Financieros</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</body>
</html>
