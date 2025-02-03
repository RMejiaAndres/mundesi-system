<?php
session_start();
require_once "../config/database.php";

// Verificar si el usuario tiene el rol adecuado
if ($_SESSION["role"] !== "coordinator" && $_SESSION["role"] !== "therapist") {
    echo "Acceso denegado.";
    exit();
}

// Obtener citas programadas
$query = "SELECT * FROM schedules
          INNER JOIN patients ON schedules.patient_id = patients.id
          WHERE therapist_id = ? OR coordinator_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $_SESSION["user_id"], $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Citas</title>
</head>
<body>
    <h2>Citas Programadas</h2>
    <table border="1">
        <tr>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row["name"] ?></td>
            <td><?= $row["date"] ?></td>
            <td><?= $row["time"] ?></td>
            <td><?= $row["status"] ?></td>
            <td>
                <!-- Formulario para editar o eliminar cita -->
                <a href="edit_schedule.php?id=<?= $row['id'] ?>">Editar</a>
                <a href="../scripts/delete_schedule.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar esta cita?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
