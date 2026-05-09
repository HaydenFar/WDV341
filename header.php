<?php
// header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WDV341 Final Project - Events App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { margin:0; font-family: Arial, sans-serif; background:#f4f4f4; }
        header { background:#1f2937; color:#fff; padding:15px 20px; }
        header h1 { margin:0; font-size:1.6rem; }
        nav { background:#374151; padding:10px 20px; display:flex; gap:15px; flex-wrap:wrap; }
        nav a {
            color:#fff; text-decoration:none; font-weight:bold; padding:6px 10px;
            border-radius:4px;
        }
        nav a:hover { background:#4b5563; }
        main {
            max-width:1000px; margin:20px auto; background:#fff; padding:20px;
            border-radius:6px; box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        footer {
            text-align:center; padding:15px; background:#1f2937; color:#fff; margin-top:20px;
        }
        .btn {
            display:inline-block; padding:8px 14px; background:#2563eb; color:#fff;
            text-decoration:none; border-radius:4px; font-size:0.9rem;
        }
        .btn:hover { background:#1d4ed8; }
        .error { background:#fee2e2; padding:10px; border-left:4px solid #dc2626; margin-bottom:10px; }
        .success { background:#dcfce7; padding:10px; border-left:4px solid #16a34a; margin-bottom:10px; }
    </style>
</head>
<body>

<header>
    <h1>WDV341 Final Project - Event Manager</h1>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="eventsPublic.php">Events</a>
    <a href="contact.php">Contact</a>
    <a href="login.php">Admin Login</a>
</nav>

<main>
