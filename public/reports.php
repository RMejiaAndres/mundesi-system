<?php
session_start();
require_once "../config/database.php";

// Verificar si el usuario tiene permisos de coordinador
if ($_SESSION["role"] !== "coordinator") {
    echo "Acceso denegado.";
    exit();
}

// Consultar ingresos de cada terapeuta
$query = "SELECT u.name, p.total_income
          FROM users u
          LEFT JOIN payments p ON u.id = p.therapist_id
          GROUP BY u.id";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ingresos</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h2>Reporte de Ingresos de Terapias</h2>
    
    <table>
        <thead>
            <tr>
                <th>Terapeuta</th>
                <th>Ingreso Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td>$<?= number_format($row['total_income'], 2) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
