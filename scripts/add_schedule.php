<?php
session_start();
require_once "../config/database.php";

// Verificar si el usuario tiene el rol adecuado
if ($_SESSION["role"] !== "coordinator" && $_SESSION["role"] !== "therapist") {
    echo "Acceso denegado.";
    exit();
}

// Procesar formulario de nueva cita
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST["patient_id"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $status = "Programada"; // Estado inicial

    $query = "INSERT INTO schedules (patient_id, therapist_id, date, time, status)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisss", $patient_id, $_SESSION["user_id"], $date, $time, $status);

    if ($stmt->execute()) {
        echo "Cita agregada exitosamente.";
    } else {
        echo "Error al agregar la cita.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cita</title>
</head>
<body>
    <h2>Agregar Nueva Cita</h2>
    <form method="post">
        <label for="patient_id">Seleccionar Paciente:</label>
        <select name="patient_id" id="patient_id" required>
            <!-- Obtener pacientes de la base de datos -->
            <?php
            $query = "SELECT * FROM patients WHERE therapist_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $_SESSION["user_id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['id']."'>".$row['name']."</option>";
            }
            ?>
        </select><br>

        <label for="date">Fecha:</label>
        <input type="date" name="date" required><br>

        <label for="time">Hora:</label>
        <input type="time" name="time" required><br>

        <button type="submit">Agregar Cita</button>
    </form>
</body>
</html>
