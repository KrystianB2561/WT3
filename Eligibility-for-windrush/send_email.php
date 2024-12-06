<?php
require 'vendor/autoload.php'; // This will automatically load all necessary classes

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit; // Stop further execution
}

// Check if email and result data are set
if (isset($_POST['email']) && isset($_POST['resultTitle']) && isset($_POST['resultDescription'])) {
    $email = $_POST['email'];
    $resultTitle = $_POST['resultTitle'];
    $resultDescription = $_POST['resultDescription'];

    $mail = new PHPMailer(true); // Create a new PHPMailer instance
    try {
        // Server settings
        $mail->isSMTP();  // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
        $mail->SMTPAuth = true;  // Enable SMTP authentication
        $mail->Username = 'liverpoolwindrush@gmail.com';  // SMTP username (your Gmail address)
        $mail->Password = 'liverpoolwindrush12345';  // SMTP password (use app password if 2FA is enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port = 587;  // TCP port to connect to (587 is for TLS)

        // Recipients
        $mail->setFrom('liverpoolwindrush@gmail.com', 'UK Eligibility Team');  // Sender's email
        $mail->addAddress($email);  // Recipient's email

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = 'UK Eligibility Assessment Results';
        $mail->Body    = "<p>Dear User,</p>
                          <p>Here are your UK Eligibility results:</p>
                          <p><strong>Result:</strong> $resultTitle</p>
                          <p><strong>Description:</strong> $resultDescription</p>
                          <p>Best regards,<br>UK Eligibility Team</p>";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "Message has been sent"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid email address or missing data"]);
}
?>