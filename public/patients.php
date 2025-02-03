<?php
session_start();
require_once "../config/database.php";

if ($_SESSION["role"] !== "therapist") {
    echo "Acceso denegado.";
    exit();
}

// Obtener lista de pacientes
$query = "SELECT * FROM patients WHERE therapist_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gestión de Pacientes</title>
</head>
<body>
    <h2>Lista de Pacientes</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Diagnóstico</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?= $row["name"] ?></td>
            <td><?= $row["age"] ?></td>
            <td><?= $row["diagnosis"] ?></td>
            <td>
                <a href="edit_patient.php?id=<?= $row['id'] ?>">Editar</a>
                <a href="../scripts/delete_patient.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_patient.php">Agregar Paciente</a>
</body>
</html>
