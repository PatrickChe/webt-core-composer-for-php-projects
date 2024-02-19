<?php
require_once "../webt-core-composer-for-php-projects/vendor/autoload.php";

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\RoundBlockSizeMode;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get phone number from the form
    $phoneNumber = isset($_POST["phone_number"]) ? $_POST["phone_number"] : "";

    // Create QR code for the phone number
    $writer = new PngWriter();
    $qrCode = QrCode::create($phoneNumber)
        ->setEncoding(new Encoding('UTF-8'))
        ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
        ->setSize(300)
        ->setMargin(10)
        ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
        ->setForegroundColor(new Color(0, 0, 0))
        ->setBackgroundColor(new Color(255, 255, 255));

    $result = $writer->write($qrCode);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded shadow-md w-full md:w-1/2 lg:w-1/3">
        <h2 class="text-2xl mb-4">Generate QR Code</h2>
        <form method="post" action="" class="mb-8">
            <input type="text" name="phone_number" placeholder="Enter your phone number" class="w-full px-4 py-2 mb-4 border rounded-md" required>
            <br>
            <div class="flex justify-center">
                <input type="submit" value="Generate QR Code" class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer">
            </div>
        </form>

        <?php
        // Display the QR code if it's generated
        if (isset($result)) {
            echo '<img src="data:' . $result->getMimeType() . ';base64,' . base64_encode($result->getString()) . '" class="mx-auto" />';
        }
        ?>

    </div>

</body>

</html>