<?php
require 'dbConnect.php';

// Hard‑code an event ID for testing
$eventID = 1;

// 1. SELECT one event using WHERE + prepared statement

try {
    $sql = "SELECT events_id, events_name, events_description, events_presenter, events_date, events_time 
            FROM events 
            WHERE events_id = :eventID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch as associative array
    $eventRow = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// If no event found
if (!$eventRow) {
    echo "<p>No event found for ID $eventID.</p>";
    exit;
}

// 2. Event Class

class Event {
    public $id;
    public $name;
    public $description;
    public $presenter;
    public $date;
    public $time;
}

// 3. Create Event object and assign values

$outputObj = new Event();

$outputObj->id          = $eventRow['events_id'];
$outputObj->name        = $eventRow['events_name'];
$outputObj->description = $eventRow['events_description'];
$outputObj->presenter   = $eventRow['events_presenter'];
$outputObj->date        = $eventRow['events_date'];
$outputObj->time        = $eventRow['events_time'];

// 4. Output each field as its own paragraph

echo "<p><strong>ID:</strong> " . $outputObj->id . "</p>";
echo "<p><strong>Name:</strong> " . $outputObj->name . "</p>";
echo "<p><strong>Description:</strong> " . $outputObj->description . "</p>";
echo "<p><strong>Presenter:</strong> " . $outputObj->presenter . "</p>";
echo "<p><strong>Date:</strong> " . $outputObj->date . "</p>";
echo "<p><strong>Time:</strong> " . $outputObj->time . "</p>";

echo json_encode($outputObj);

?>
