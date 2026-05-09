<?php
session_start();
require 'dbConnect.php';

// Must be logged in
if (empty($_SESSION['validUser'])) {
    header("Location: login.php");
    exit;
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: adminViewEvents.php?msg=error&text=Invalid+event+ID");
    exit;
}

$eventId = intval($_GET['id']);

try {
    $sql = "DELETE FROM events WHERE events_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $eventId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: adminViewEvents.php?msg=success&text=Event+deleted+successfully");
    } else {
        header("Location: adminViewEvents.php?msg=error&text=Event+not+found");
    }
    exit;

} catch (PDOException $e) {
    error_log("Delete error: " . $e->getMessage());
    header("Location: adminViewEvents.php?msg=error&text=Database+error");
    exit;
}
?>
