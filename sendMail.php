<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include the PHPMailer Autoload file
require __DIR__ . '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Set the recipient email address
    $to = "example@domain.com";
    $mailFrom = "example@domain.com";

    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];


    // Compose the email message
    $email_message = "Name: $name\n";
    $email_message .= "Phone: $phone\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Subject: $subject\n";
    $email_message .= "Message: $message\n\n";


    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'your_smtp_server'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'smtp_user_name';   // SMTP username
        $mail->Password   = 'smtp_pass';   // SMTP password
        $mail->SMTPSecure = 'tls';                  // Enable TLS encryption, 'ssl' also accepted
        $mail->Port       = 587;                    // TCP port to connect to

        // Recipients
        $mail->setFrom($mailFrom, $name);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);  // Set to true if your message is HTML
        $mail->Subject = $subject;
        $mail->Body    = $email_message;

        $mail->send();
        
        // Redirect to thankyou.html on success
        header("Location: thankyou.html");
        exit;
    } catch (Exception $e) {
        echo "Error: Unable to send the message. Please try again later. Error: {$mail->ErrorInfo}";
    }

} else {
    // If the request method is not POST, redirect or handle accordingly
    echo "Invalid request method.";
}

?>
