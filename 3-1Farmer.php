<?php
    // 1. Format Unix timestamp as mm/dd/yyyy
    function formatUSDate($timestamp) {
        return date("m/d/Y", $timestamp);
    }

    // 2. Format Unix timestamp as dd/mm/yyyy (international)
    function formatInternationalDate($timestamp) {
        return date("d/m/Y", $timestamp);
    }

    // 3. String processing function
    function processString($str) {
        echo "<h3>String Processing</h3>";

        // Number of characters
        echo "Number of characters: " . strlen($str) . "<br>";

        // Trim whitespace
        $trimmed = trim($str);
        echo "Trimmed string: '$trimmed'<br>";

        // Lowercase
        echo "Lowercase: " . strtolower($trimmed) . "<br>";

        // Contains DMACC?
        if (stripos($trimmed, "DMACC") !== false) {
            echo "Contains 'DMACC'<br>";
        } else {
            echo "Does NOT contain 'DMACC'<br>";
        }
    }

    // 4. Format phone number
    function formatPhoneNumber($num) {
        $num = preg_replace("/[^0-9]/", "", $num); // remove non-digits
        $area = substr($num, 0, 3);
        $prefix = substr($num, 3, 3);
        $line = substr($num, 6, 4);
        return "($area) $prefix-$line";
    }

    // 5. Format as US currency
    function formatCurrency($amount) {
        return "$" . number_format($amount, 2);
    }

    // Test values
    $timestamp = time();
    $testString = "   Welcome to DMACC PHP Class   ";
    $testPhone = 1234567890;
    $testMoney = 123456;
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Functions Assignment</title>
</head>
<body>

<h1>PHP Functions Assignment</h1>

<h2>Date Formatting</h2>
<p>US Format (mm/dd/yyyy): <?php echo formatUSDate($timestamp); ?></p>
<p>International Format (dd/mm/yyyy): <?php echo formatInternationalDate($timestamp); ?></p>

<?php processString($testString); ?>

<h3>Phone Number Formatting</h3>
<p><?php echo formatPhoneNumber($testPhone); ?></p>

<h3>Currency Formatting</h3>
<p><?php echo formatCurrency($testMoney); ?></p>

</body>
</html>
