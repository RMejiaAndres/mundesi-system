<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "therapist") {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Conexión a la base de datos
    require_once 'db_config.php';
    
    // Recibir los datos del formulario
    $patient_name = $_POST['patient_name'];
    $patient_age = $_POST['patient_age'];
    $patient_diagnosis = $_POST['patient_diagnosis'];
    $therapist_id = $_SESSION['user_id']; // El terapeuta que está creando el paciente

    // Preparar la consulta para insertar el paciente
    $sql = "INSERT INTO patients (name, age, diagnosis, therapist_id) VALUES (?, ?, ?, ?)";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("sisi", $patient_name, $patient_age, $patient_diagnosis, $therapist_id);
        $stmt->execute();
        $stmt->close();
        echo "Paciente agregado exitosamente.";
    } else {
        echo "Error al agregar paciente: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Paciente</title>
</head>
<body>
    <h2>Agregar Nuevo Paciente</h2>
    <form action="add_patient.php" method="POST">
        <label for="patient_name">Nombre del paciente:</label>
        <input type="text" name="patient_name" required><br>

        <label for="patient_age">Edad:</label>
        <input type="number" name="patient_age" required><br>

        <label for="patient_diagnosis">Diagnóstico:</label>
        <textarea name="patient_diagnosis" required></textarea><br>

        <button type="submit">Agregar Paciente</button>
    </form>
</body>
</html>
