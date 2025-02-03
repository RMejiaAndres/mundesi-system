<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "therapist") {
    header("Location: index.php");
    exit();
}

require_once 'db_config.php';

// Obtener todos los pacientes del terapeuta logueado
$sql = "SELECT * FROM patients WHERE therapist_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pacientes</title>
</head>
<body>
    <h2>Listado de Pacientes</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Edad</th>
            <th>Diagnóstico</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['age']); ?></td>
            <td><?php echo htmlspecialchars($row['diagnosis']); ?></td>
            <td>
                <a href="edit_patient.php?patient_id=<?php echo $row['id']; ?>">Editar</a>
                <a href="delete_patient.php?patient_id=<?php echo $row['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este paciente?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
