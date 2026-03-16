<?php

require 'sendEmail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(trim($_POST["contactName"]));
    $email = filter_var(trim($_POST["contactEmail"]), FILTER_VALIDATE_EMAIL);
    $reason = htmlspecialchars(trim($_POST["contactReason"]));
    $comments = htmlspecialchars(trim($_POST["comments"]));
    $date = date("m/d/Y");

    if (!$email) {
        die("Invalid email address.");
    }

    // Email sent to you
    $yourEmail = "hmfarmer101@gmail.com";

    $adminSubject = "New Contact Form Submission";

    $adminBody = "
    <h2>New Contact Submission</h2>
    <ul>
        <li><strong>Date:</strong> $date</li>
        <li><strong>Name:</strong> $name</li>
        <li><strong>Email:</strong> $email</li>
        <li><strong>Reason:</strong> $reason</li>
        <li><strong>Comments:</strong> $comments</li>
    </ul>
    ";

    sendEmail($yourEmail, $adminSubject, $adminBody);

    // Confirmation email to customer

    $customerSubject = "We Received Your Message";

    $customerBody = "
    <html>
    <body style='font-family:Arial; background:#f4f4f4; padding:20px;'>
        <div style='background:white; padding:20px; border-radius:8px;'>
            <h2>Thank You, $name!</h2>
            <p>We received your message on $date.</p>
            <p><strong>Reason:</strong> $reason</p>
            <p><strong>Your Message:</strong></p>
            <p>$comments</p>
            <br>
            <p>We will get back to you shortly.</p>
        </div>
    </body>
    </html>
    ";

    sendEmail($email, $customerSubject, $customerBody);

    echo "<h2>Thank you! Your message has been sent.</h2>";
}
?>