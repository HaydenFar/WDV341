<?php
// updateEvent.php
// Hayden Farmer - WDV341 Spring 2026

session_start();
require_once("dbConnect.php");

// Generate CSRF token if not set
if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
}

// Initialize variables
$event = null;
$message = "";
$error = "";

// Validate recid
if (!isset($_GET['recid']) || !is_numeric($_GET['recid'])) {
    die("Invalid event ID.");
}

$recid = intval($_GET['recid']);

// STEP 1: Load event data
try {
    $stmt = $conn->prepare("SELECT * FROM events WHERE events_id = :id");
    $stmt->bindParam(":id", $recid);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        die("Event not found.");
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// STEP 2: Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF check
    if (!isset($_POST['form_token']) || $_POST['form_token'] !== $_SESSION['form_token']) {
        die("Invalid form submission.");
    }

    // Honeypot check
    if (!empty($_POST['website'])) {
        die("Bot detected.");
    }

    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $presenter = htmlspecialchars(trim($_POST['presenter']));
    $date = htmlspecialchars(trim($_POST['date']));
    $time = htmlspecialchars(trim($_POST['time']));

    // Basic validation
    if (empty($name) || empty($description) || empty($presenter) || empty($date) || empty($time)) {
        $error = "All fields are required.";
    } else {
        try {
            $update = $conn->prepare("
                UPDATE events 
                SET events_name = :name,
                    events_description = :description,
                    events_presenter = :presenter,
                    events_date = :date,
                    events_time = :time
                WHERE events_id = :id
            ");

            $update->bindParam(":name", $name);
            $update->bindParam(":description", $description);
            $update->bindParam(":presenter", $presenter);
            $update->bindParam(":date", $date);
            $update->bindParam(":time", $time);
            $update->bindParam(":id", $recid);

            $update->execute();

            $message = "Event updated successfully!";
        } catch (PDOException $e) {
            $error = "Update failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 40px;
        }
        .container {
            width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 12px rgba(0,0,0,0.15);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 12px;
        }
        input[type="text"], input[type="date"], input[type="time"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        textarea {
            height: 100px;
        }
        .btn {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background: #4a67d6;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background: #3b55b3;
        }
        .success {
            background: #d4edda;
            padding: 12px;
            border-left: 5px solid #28a745;
            margin-bottom: 15px;
        }
        .error {
            background: #f8d7da;
            padding: 12px;
            border-left: 5px solid #dc3545;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <h1>Update Event</h1>

    <?php if ($message): ?>
        <div class="success"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">

        <label>Event Name:</label>
        <input type="text" name="name" value="<?= $event['events_name'] ?>" required>

        <label>Description:</label>
        <textarea name="description" required><?= $event['events_description'] ?></textarea>

        <label>Presenter:</label>
        <input type="text" name="presenter" value="<?= $event['events_presenter'] ?>" required>

        <label>Date:</label>
        <input type="date" name="date" value="<?= $event['events_date'] ?>" required>

        <label>Time:</label>
        <input type="time" name="time" value="<?= $event['events_time'] ?>" required>

        <!-- CSRF Token -->
        <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">

        <!-- Honeypot -->
        <p style="display:none;">
            <input type="text" name="website" value="">
        </p>

        <button type="submit" class="btn">Update Event</button>
    </form>
</div>
</body>
</html>
