<?php
session_start();
if (empty($_SESSION['validUser'])) {
    header("Location: login.php");
    exit;
}
require 'dbConnect.php';
include 'header.php';

$msg = $_GET['msg'] ?? "";
$text = $_GET['text'] ?? "";

try {
    $sql = "SELECT events_id, events_name, events_presenter, events_date, events_time
            FROM events
            ORDER BY events_date, events_time";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("DB Error in adminViewEvents.php: " . $e->getMessage());
    $events = [];
}
?>

<h2>All Events</h2>

<?php if ($msg && $text): ?>
    <div class="<?php echo $msg === 'success' ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($text); ?>
    </div>
<?php endif; ?>

<?php if (empty($events)): ?>
    <p>No events found.</p>
<?php else: ?>
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Name</th>
            <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Presenter</th>
            <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Date</th>
            <th style="text-align:left; border-bottom:1px solid #e5e7eb; padding:8px;">Time</th>
            <th style="border-bottom:1px solid #e5e7eb; padding:8px;">Actions</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td style="padding:8px;"><?php echo htmlspecialchars($event['events_name']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($event['events_presenter']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($event['events_date']); ?></td>
                <td style="padding:8px;"><?php echo htmlspecialchars($event['events_time']); ?></td>
                <td style="padding:8px;">
                    <a class="btn" href="adminUpdateEvent.php?recid=<?php echo $event['events_id']; ?>">Update</a>
                    <a class="btn" style="background:#b91c1c;"
                       href="deleteEvents.php?id=<?php echo $event['events_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>
