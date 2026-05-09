<?php
/*
    dbConnect.php
    This file creates a PDO connection to the database.
*/

$serverName = "localhost";
$dbName     = "wdv341";
$username   = "root";
$password   = "";

try {
    $dsn = "mysql:host=$serverName;dbname=$dbName;charset=utf8";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
