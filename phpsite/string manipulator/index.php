<?php
require_once "StringHandler.php";
$handler = new StringHandler();
$output = $handler->addText("world")->prependText("Hello ")->convertToUpper()->getFinalText();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>String Handler Testing</title>
</head>
<body>
    <h1>Result:</h1>

    <p><?php echo $output; ?></p>
</body>
</html>
