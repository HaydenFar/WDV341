<?php
session_start();
require 'dbConnect.php';

// Generate CSRF token
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Fetch events
try {
    $sql = "SELECT event_id, event_name, event_description, event_presenter, event_date, event_time 
            FROM events";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Events</title>
<style>
    body { font-family: Arial; background: #f4f4f4; padding: 40px; }
    h1 { text-align: center; }
    table { width: 90%; margin: 0 auto; border-collapse: collapse; background: white; }
    th, td { padding: 12px; border-bottom: 1px solid #ccc; }
    th { background: #333; color: white; }
    .deleteBtn {
        background: #c62828; color: white; padding: 8px 12px;
        border: none; border-radius: 5px; cursor: pointer;
    }
    .deleteBtn:hover { background: #e53935; }
    .message { text-align: center; font-size: 18px; margin-bottom: 20px; }
    .success { color: green; }
    .error { color: red; }
</style>
<script>
function confirmDelete(eventId) {
    if (confirm("Are you sure you want to delete this event?")) {
        window.location = "delete-event.php?id=" + eventId + "&token=<?php echo $_SESSION['token']; ?>";
    }
}
</script>
</head>

<body>

<h1>Event List</h1>

<?php
if (isset($_GET['msg'])) {
    $class = ($_GET['msg'] == "success") ? "success" : "error";
    echo "<p class='message $class'>" . htmlspecialchars($_GET['text']) . "</p>";
}
?>

<table>
<tr>
    <th>Name</th>
    <th>Description</th>
    <th>Presenter</th>
    <th>Date</th>
    <th>Time</th>
    <th>Delete</th>
</tr>

<?php foreach ($events as $event): ?>
<tr>
    <td><?= htmlspecialchars($event['event_name']) ?></td>
    <td><?= htmlspecialchars($event['event_description']) ?></td>
    <td><?= htmlspecialchars($event['event_presenter']) ?></td>
    <td><?= htmlspecialchars($event['event_date']) ?></td>
    <td><?= htmlspecialchars($event['event_time']) ?></td>
    <td>
        <button class="deleteBtn" onclick="confirmDelete(<?= $event['event_id'] ?>)">Delete</button>
    </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
