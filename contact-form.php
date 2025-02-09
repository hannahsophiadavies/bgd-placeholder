<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Change to your email address
    $email_to = "eurobig.ca@gmail.com"; 
    $email_subject = "New Contact Form Submission";

    function problem($error)
    {
        echo json_encode(["status" => "error", "message" => $error]);
        exit();
    }

    if (!isset($_POST['Name']) || !isset($_POST['Email']) || !isset($_POST['Message'])) {
        problem("All fields are required.");
    }

    $name = filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['Email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['Message'], FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        problem("Invalid email format.");
    }

    if (strlen($name) < 2) {
        problem("Name must be at least 2 characters long.");
    }

    if (strlen($message) < 5) {
        problem("Message must be at least 5 characters long.");
    }

    $email_message = "New contact form submission:\n\n";
    $email_message .= "Name: " . $name . "\n";
    $email_message .= "Email: " . $email . "\n";
    $email_message .= "Message: " . $message . "\n";

    $headers = 'From: ' . $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if (mail($email_to, $email_subject, $email_message, $headers)) {
        echo json_encode(["status" => "success", "message" => "Thank you! Your message has been sent."]);
    } else {
        problem("There was an issue sending your message. Please try again later.");
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>