<!DOCTYPE html>
<head>
<meta charset="utf-8" />
<title>DMACC Form Confirmation</title>

<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #f2f6fa;
        padding: 20px;
    }

    .container {
        width: 650px;
        margin: auto;
        background-color: #ffffff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.15);
    }

    h1 {
        text-align: center;
    }
</style>

</head>

<body>

<div class="container">

<?php
require_once("functions.php");

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Honeypot
    if (!empty($_POST['website'])) {
        echo "<h1>Form Submission Failed</h1>";
        echo "<p>Bot activity detected. Submission blocked.</p>";
        exit;
    }

    // Safe values
    $first = htmlspecialchars($_POST['first_name']);
    $standing = htmlspecialchars($_POST['academic_standing']);
    $major = htmlspecialchars($_POST['major']);
    $email = htmlspecialchars($_POST['email']);

    $contactInfo = isset($_POST['contact_info']) ? htmlspecialchars($_POST['contact_info']) : "";
    $advisorRequest = isset($_POST['advisor_request']) ? htmlspecialchars($_POST['advisor_request']) : "";

    $comments = htmlspecialchars($_POST['comments']);

    echo "<h1>Thank You!</h1>";

    echo "<p>Dear $first,</p>";

    echo "<p>Thank you for your interest in DMACC.</p>";

    echo "<p>We have you listed as a <strong>$standing</strong> starting this fall.</p>";

    echo "<p>You have declared <strong>$major</strong> as your major.</p>";

    echo "<p>Based upon your responses we will provide the following information in our confirmation email to you at <strong>$email</strong>.</p>";

    if ($contactInfo !== "") {
        echo "<p>$contactInfo</p>";
    }

    if ($advisorRequest !== "") {
        echo "<p>$advisorRequest</p>";
    }

    echo "<p>You have shared the following comments which we will review:</p>";
    echo "<p><em>$comments</em></p>";

} else {
    echo "<h1>Invalid Request</h1>";
    echo "<p>Please return to the form page.</p>";
}
?>

</div>

</body>
</html>