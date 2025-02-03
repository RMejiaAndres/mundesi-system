<?php
session_start();
require_once "../config/database.php";

// Verificar que el usuario sea coordinador
if ($_SESSION["role"] !== "coordinator") {
    echo "Acceso denegado.";
    exit();
}

// Validar datos del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $therapist_id = $_POST["therapist_id"];
    $therapy_count = $_POST["therapy_count"];
    $evaluation_count = $_POST["evaluation_count"];
    $date = $_POST["date"];

    // Insertar el pago en la base de datos
    $query = "INSERT INTO payments (therapist_id, therapy_count, evaluation_count, date) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiis", $therapist_id, $therapy_count, $evaluation_count, $date);

    if ($stmt->execute()) {
        echo "Pago registrado con éxito.";
    } else {
        echo "Error al registrar el pago.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago de Terapia</title>
</head>
<body>
    <h2>Registrar Pago de Terapia</h2>
    <form action="add_payment.php" method="POST">
        <label for="therapist_id">Seleccionar Terapeuta:</label>
        <select name="therapist_id" id="therapist_id" required>
            <?php
            // Obtener terapeutas
            $query = "SELECT id, name FROM users WHERE role = 'therapist'";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="therapy_count">Número de Terapias:</label>
        <input type="number" name="therapy_count" id="therapy_count" required><br><br>

        <label for="evaluation_count">Número de Evaluaciones:</label>
        <input type="number" name="evaluation_count" id="evaluation_count" required><br><br>

        <label for="date">Fecha del Pago:</label>
        <input type="date" name="date" id="date" required><br><br>

        <input type="submit" value="Registrar Pago">
    </form>
</body>
</html>
