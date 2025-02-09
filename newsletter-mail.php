<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $to = "eurobig.ca@gmail.com"; // Change to EUROBIG email
        $subject = "New Newsletter Subscription";
        $message = "A new user subscribed: " . $email;
        $headers = "From: newsletter@eurobig-network.com\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo json_encode(["success" => "Subscription successful!"]);
        } else {
            echo json_encode(["error" => "Failed to send email."]);
        }
    } else {
        echo json_encode(["error" => "Invalid email address."]);
    }
}
?>
