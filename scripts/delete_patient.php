<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "therapist") {
    header("Location: index.php");
    exit();
}

if (isset($_GET['patient_id'])) {
    // Conexión a la base de datos
    require_once 'db_config.php';
    
    // Obtener el ID del paciente a eliminar
    $patient_id = $_GET['patient_id'];

    // Verificar que el paciente pertenece al terapeuta
    $sql_check = "SELECT therapist_id FROM patients WHERE id = ?";
    if ($stmt_check = $mysqli->prepare($sql_check)) {
        $stmt_check->bind_param("i", $patient_id);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) {
            $stmt_check->bind_result($therapist_id);
            $stmt_check->fetch();

            // Si el paciente pertenece al terapeuta, proceder a eliminar
            if ($therapist_id == $_SESSION['user_id']) {
                // Preparar la consulta para eliminar el paciente
                $sql = "DELETE FROM patients WHERE id = ?";
                if ($stmt = $mysqli->prepare($sql)) {
                    $stmt->bind_param("i", $patient_id);
                    $stmt->execute();
                    $stmt->close();
                    echo "Paciente eliminado exitosamente.";
                } else {
                    echo "Error al eliminar paciente: " . $mysqli->error;
                }
            } else {
                echo "No tienes permiso para eliminar este paciente.";
            }
        } else {
            echo "Paciente no encontrado.";
        }
    }
}
?>

