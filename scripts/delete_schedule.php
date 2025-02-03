<?php
session_start();
require_once "../config/database.php";

// Verificar si el usuario tiene el rol adecuado
if ($_SESSION["role"] !== "coordinator" && $_SESSION["role"] !== "therapist") {
    echo "Acceso denegado.";
    exit();
}

// Verificar que el ID de la cita esté presente
if (isset($_GET['id'])) {
    $schedule_id = $_GET['id'];

    // Verificar que la cita pertenece al usuario (terapeuta o coordinador)
    $query = "SELECT * FROM schedules WHERE id = ? AND (therapist_id = ? OR coordinator_id = ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $schedule_id, $_SESSION["user_id"], $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si la cita pertenece al usuario, eliminarla
        $query = "DELETE FROM schedules WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $schedule_id);

        if ($stmt->execute()) {
            echo "Cita eliminada con éxito.";
        } else {
            echo "Error al eliminar la cita.";
        }
    } else {
        echo "No tienes permisos para eliminar esta cita.";
    }
} else {
    echo "ID de cita no válido.";
}
?>
