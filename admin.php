<?php
session_start();
if (empty($_SESSION['validUser'])) {
    header("Location: login.php");
    exit;
}
include 'header.php';
?>

<h2>Admin Dashboard</h2>
<p>Welcome to the administration area.</p>

<p>
    <a href="adminAddEvent.php" class="btn">Add New Event</a>
    <a href="adminViewEvents.php" class="btn">View All Events</a>
    <a href="logout.php" class="btn" style="background:#6b7280;">Logout</a>
</p>

<?php include 'footer.php'; ?>
