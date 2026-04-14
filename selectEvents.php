<?php
// Connect to database
require 'dbConnect.php';

// Prepare SQL SELECT
try {
    $sql = "SELECT events_name, events_description, events_presenter, events_date, events_time 
            FROM <haydenfarmer_wdv341.events";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #333;
            color: white;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .no-events {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 40px;
            color: #555;
        }
    </style>
</head>

<body>

<h1>Event List</h1>

<?php if (empty($events)) : ?>

    <p class="no-events">There are currently no events in the database.</p>

<?php else : ?>

    <table>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Presenter</th>
            <th>Date</th>
            <th>Time</th>
        </tr>

        <?php foreach ($events as $event) : ?>
            <tr>
                <td><?= htmlspecialchars($event['events_name']) ?></td>
                <td><?= htmlspecialchars($event['events_description']) ?></td>
                <td><?= htmlspecialchars($event['events_presenter']) ?></td>
                <td><?= htmlspecialchars($event['events_date']) ?></td>
                <td><?= htmlspecialchars($event['events_time']) ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php endif; ?>

</body>
</html>
