<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = trim($_POST["email"]);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "invalid";  // Response for AJAX
        exit();
    }

    // File to store emails (can be replaced with a database)
    $file = "subscribers.txt";

    // Prevent duplicate entries
    $subscribers = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    if (in_array($email, $subscribers)) {
        echo "duplicate";  // Already subscribed
        exit();
    }

    // Append email to the file
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND);

    // Optional: Send confirmation email (uncomment to enable)
    /*
    $subject = "Newsletter Subscription Confirmation";
    $message = "Thank you for subscribing to the EUROBIG Newsletter!";
    $headers = "From: no-reply@yourdomain.com\r\nReply-To: no-reply@yourdomain.com";
    mail($email, $subject, $message, $headers);
    */

    echo "success"; // Response for AJAX
} else {
    echo "error"; // If the request is not POST
}
?>
