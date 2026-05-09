<?php
require 'dbConnect.php';
include 'header.php';

try {
    $sql = "SELECT events_id, events_name, events_description, events_presenter, events_date, events_time
            FROM events
            ORDER BY events_date, events_time";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("DB Error in eventsPublic.php: " . $e->getMessage());
    $events = [];
}
?>

<h2>Upcoming Events</h2>

<?php if (empty($events)) : ?>
    <p>No events are currently scheduled.</p>
<?php else : ?>
    <div style="display:grid; gap:15px;">
        <?php foreach ($events as $event): ?>
            <div style="border:1px solid #e5e7eb; padding:12px; border-radius:6px;">
                <h3><?php echo htmlspecialchars($event['events_name']); ?></h3>
                <p><strong>Presenter:</strong> <?php echo htmlspecialchars($event['events_presenter']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($event['events_date']); ?>
                   <strong>Time:</strong> <?php echo htmlspecialchars($event['events_time']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($event['events_description'])); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
