<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$role = $_SESSION["role"];

switch ($role) {
    case "admin":
        header("Location: admin_dashboard.php");
        break;
    case "coordinator":
        header("Location: coordinator_dashboard.php");
        break;
    case "therapist":
        header("Location: therapist_dashboard.php");
        break;
    default:
        echo "Error: Rol no reconocido.";
}
exit();
?>
