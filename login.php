<?php
session_start();
require 'dbConnect.php';

$loginError = "";

// If form submitted, validate login
if (isset($_POST['loginSubmit'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        $sql = "SELECT events_user_name, events_user_password 
                FROM events_user 
                WHERE events_user_name = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $password === $row['events_user_password']) {
            $_SESSION['validUser'] = true;
        } else {
            $_SESSION['validUser'] = false;
            $loginError = "Invalid username or password.";
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Administrator Login</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f4f4;
        padding: 40px;
    }
    .container {
        width: 450px;
        margin: 0 auto;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }
    h1 { text-align: center; }
    label { font-weight: bold; display: block; margin-top: 15px; }
    input {
        width: 100%; padding: 10px; margin-top: 5px;
        border: 1px solid #ccc; border-radius: 5px;
    }
    .btn {
        margin-top: 20px; width: 100%; padding: 12px;
        background: #333; color: white; border: none;
        border-radius: 5px; cursor: pointer; font-size: 16px;
    }
    .btn:hover { background: #555; }
    .error { color: red; text-align: center; margin-top: 10px; }
    .menu a {
        display: block;
        padding: 12px;
        background: #333;
        color: white;
        text-decoration: none;
        margin-top: 10px;
        border-radius: 5px;
        text-align: center;
    }
    .menu a:hover { background: #555; }
</style>
</head>

<body>

<div class="container">

<?php
// If user is logged in, show admin menu
if (isset($_SESSION['validUser']) && $_SESSION['validUser'] === true) :
?>

    <h1>Administrator Menu</h1>

    <div class="menu">
        <a href="eventInputForm.php">Add New Event</a>
        <a href="selectEvents.php">View / Update / Delete Events</a>
        <a href="logout.php">Logout</a>
    </div>

<?php
// Otherwise show login form
else :
?>

    <h1>Administrator Login</h1>

    <?php if ($loginError) echo "<p class='error'>$loginError</p>"; ?>

    <form method="post" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit" name="loginSubmit" class="btn">Login</button>
    </form>

<?php endif; ?>

</div>

</body>
</html>
