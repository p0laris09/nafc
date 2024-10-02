<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Include Composer's autoload file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                    // Use SMTP
        $mail->Host = 'smtp.gmail.com';                     // Specify main SMTP server (update as needed)
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = 'email@email.com';   // SMTP username (update with your email)
        $mail->Password = 'password';               // SMTP password (update with the correct password or API key)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` for SSL
        $mail->Port = 587;                                  // TCP port to connect to (update as needed)

        // Recipients
        $mail->setFrom('email@email.com', 'Contact Us Message');  // Sender email and name
        $mail->addAddress('email@email.com');           // Recipient email address (update as needed)

        // Embed the logo image (ensure the path is correct)
        $mail->addEmbeddedImage('img/NAFC-Logo-03.png', 'logo'); // Replace 'path/to/logo.png' with the correct path to your logo

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Contact Us: $subject";               // Email subject

        // Add the embedded image in the email body using the embedded image ID (cid)
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #e0e0e0; border-radius: 5px; overflow: hidden;'>
            <div style='background-color: #000000; color: #ffffff; padding: 20px; text-align: center;'>
                <img src='cid:logo' alt='Company Logo' style='width: 350px;'>
                <h2 style='margin: 0;'>Contact Us Form Submission</h2>
            </div>
            <div style='padding: 20px;'>
                <p style='font-size: 16px; line-height: 1.5;'>
                    <strong style='color: #000000;'>Name:</strong> <span>$name</span><br>
                    <strong style='color: #000000;'>Email:</strong> <span>$email</span><br>
                    <strong style='color: #000000;'>Message:</strong><br>
                    <blockquote style='border-left: 3px solid #000000; margin: 10px 0; padding: 10px; font-style: italic;'>
                        $message
                    </blockquote>
                </p>
            </div>
            <div style='background-color: #f8f9fa; text-align: center; padding: 10px;'>
            </div>
        </div>
        ";  // Email body content with the logo and styling

        // Send email
        $mail->send();
        echo "<script>alert('Message has been sent successfully!'); window.location.href ='contact.php';</script>";
    } catch (Exception $e) {
        // Error handling
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href ='contact.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.location.href ='contact.php';</script>";
}
?>
