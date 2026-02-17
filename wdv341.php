<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WDV341 Homework</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1f2937;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #374151;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #ffffff;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            max-width: 800px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 6px;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #1f2937;
            color: #ffffff;
            margin-top: 20px;
        }
        h2 {
            color: #1f2937;
        }
    </style>
</head>
<body>

<header>
    <h1>WDV341 – PHP Homework</h1>
    <p>Intro to PHP</p>
</header>

<nav>
    <a href="#">Home</a>
    <a href="#">Assignments</a>
    <a href="#">Contact</a>
</nav>

<main>
    <h2>Homework Assignment</h2>
    <p>
        <?php
            echo "Hello, my name is Hayden Farmer and this page was created using PHP.";
        ?>
    </p>

    <h3>Current Date</h3>
    <p>
        <?php
            echo date("l, F j, Y");
        ?>
    </p>

    <h3>Course Info</h3>
    <ul>
        <li>Course: WDV341</li>
        <li>Topic: PHP Basics</li>
    </ul>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Hayden Farmer</p>
</footer>

</body>
</html>
