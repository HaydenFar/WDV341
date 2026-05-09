<?php
include 'header.php';

$name = $email = $message = "";
$errors = [];
$submitted = false;

// Simple honeypot + required fields
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['website'])) {
        // Extra credit: Access denied
        echo '<div class="error"><strong>Access Denied.</strong></div>';
        echo '<p><a href="contact.php" class="btn">Reload Contact Page</a></p>';
        include 'footer.php';
        exit;
    }

    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $message = trim($_POST['message'] ?? "");

    if ($name === "") $errors[] = "Name is required.";
    if ($email === "") $errors[] = "Email is required.";
    if ($message === "") $errors[] = "Message is required.";

    if (empty($errors)) {
        $to = "your-email@example.com"; // replace with your email
        $subject = "Contact Form Submission from $name";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // send to you
        @mail($to, $subject, $body, "From: $email");

        // send copy to user
        @mail($email, "Copy of your submission", $body, "From: $to");

        $submitted = true;
    }
}
?>

<h2>Contact Us</h2>

<?php if ($submitted && empty($errors)): ?>

    <div class="success">
        Thank you, <?php echo htmlspecialchars($name); ?>. Your message has been sent successfully.
    </div>

<?php else: ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $err) echo htmlspecialchars($err) . "<br>"; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="contact.php">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label>Message:</label>
        <textarea name="message" rows="5" required><?php echo htmlspecialchars($message); ?></textarea>

        <!-- Honeypot -->
        <p style="display:none;">
            <input type="text" name="website" value="">
        </p>

        <button type="submit" class="btn">Send Message</button>
    </form>

<?php endif; ?>

<?php include 'footer.php'; ?>
