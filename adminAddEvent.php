<?php
session_start();
if (empty($_SESSION['validUser'])) {
    header("Location: login.php");
    exit;
}
require 'dbConnect.php';
include 'header.php';

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['website'])) {
        // honeypot triggered: silently ignore
    } else {
        $name = trim($_POST['events_name'] ?? "");
        $description = trim($_POST['events_description'] ?? "");
        $presenter = trim($_POST['events_presenter'] ?? "");
        $date = $_POST['events_date'] ?? "";
        $time = $_POST['events_time'] ?? "";

        if ($name === "") $errors[] = "Event name is required.";
        if ($description === "") $errors[] = "Description is required.";
        if ($presenter === "") $errors[] = "Presenter is required.";
        if ($date === "") $errors[] = "Date is required.";
        if ($time === "") $errors[] = "Time is required.";

        if (empty($errors)) {
            try {
                $sql = "INSERT INTO events
                        (events_name, events_description, events_presenter, events_date, events_time, date_inserted, date_updated)
                        VALUES (:name, :description, :presenter, :date, :time, :inserted, :updated)";
                $stmt = $conn->prepare($sql);

                $today = date("Y-m-d");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':presenter', $presenter);
                $stmt->bindParam(':date', $date);
                $stmt->bindParam(':time', $time);
                $stmt->bindParam(':inserted', $today);
                $stmt->bindParam(':updated', $today);

                $stmt->execute();
                $success = "Event added successfully.";
            } catch (PDOException $e) {
                error_log("DB Error in adminAddEvent.php: " . $e->getMessage());
                $errors[] = "Database error occurred.";
            }
        }
    }
}
?>

<h2>Add New Event</h2>

<?php if ($success): ?>
    <div class="success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="error">
        <?php foreach ($errors as $err) echo htmlspecialchars($err) . "<br>"; ?>
    </div>
<?php endif; ?>

<form method="post" action="adminAddEvent.php">
    <label>Event Name:</label>
    <input type="text" name="events_name" required>

    <label>Description:</label>
    <textarea name="events_description" rows="4" required></textarea>

    <label>Presenter:</label>
    <input type="text" name="events_presenter" required>

    <label>Date:</label>
    <input type="date" name="events_date" required>

    <label>Time:</label>
    <input type="time" name="events_time" required>

    <!-- Honeypot -->
    <p style="display:none;">
        <input type="text" name="website" value="">
    </p>

    <button type="submit" class="btn">Add Event</button>
</form>

<?php include 'footer.php'; ?>
