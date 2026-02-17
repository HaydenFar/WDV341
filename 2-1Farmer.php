<?php
    // PHP variables
    $yourName = "Hayden Farmer";

    $number1 = 12;
    $number2 = 8;
    $total = $number1 + $number2;

    // PHP array
    $phpArray = array("PHP", "HTML", "Javascript");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Assignment: PHP + HTML + JS</title>
</head>
<body>

    <!-- Assignment name -->
    <h1>PHP / HTML / JavaScript Integration Assignment</h1>

    <!-- h2 element with PHP variable -->
    <h2><?php echo $yourName; ?></h2>

    <!-- Displaying number variables -->
    <p>Number 1: <?php echo $number1; ?></p>
    <p>Number 2: <?php echo $number2; ?></p>
    <p>Total: <?php echo $total; ?></p>

    <!-- Create a JS array using PHP loop -->
    <script>
        let jsArray = [
            <?php
                foreach ($phpArray as $value) {
                    echo "'" . $value . "',";
                }
            ?>
        ];

        // Display array values on the page
        document.write("<h3>Values from JavaScript Array:</h3>");
        for (let i = 0; i < jsArray.length; i++) {
            document.write(jsArray[i] + "<br>");
        }
    </script>

</body>
</html>
