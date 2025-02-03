<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "therapist") {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Panel de Terapeuta</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h1>Bienvenido Terapeuta</h1>
    <nav>
        <ul>
            <li><a href="view_patients.php">Ver Pacientes</a></li>
            <li><a href="add_patient.php">Agregar Paciente</a></li>
            <li><a href="manage_appointments.php">Citas Programadas</a></li>
            <li><a href="upload_files.php">Subir Archivos a Google Drive</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</body>
</html>
