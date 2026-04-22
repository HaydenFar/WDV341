<?php
session_start();
require 'dbConnect.php';

// CSRF check
if (!isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    header("Location: events.php?msg=error&text=Invalid+security+token");
    exit;
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: events.php?msg=error&text=Invalid+event+ID");
    exit;
}

$eventId = intval($_GET['id']);

try {
    $sql = "DELETE FROM events WHERE event_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $eventId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: events.php?msg=success&text=Event+deleted+successfully");
    } else {
        header("Location: events.php?msg=error&text=Event+not+found");
    }
    exit;

} catch (PDOException $e) {
    header("Location: events.php?msg=error&text=Database+error");
    exit;
}
?>
